<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administration | Baseball Trois-Pistoles</title>
    <link rel="stylesheet" href="../css/foundation.css" />
    <link rel="stylesheet" href="../css/datatable.min.css" />
    <link rel="stylesheet" href="../foundation-icons/foundation-icons.css" />
    <script src="../js/vendor/modernizr.js"></script>
    <script src="../js/jquery-1.11.3.min.js"></script>
    <script src="../js/datatable.min.js"></script>
</head>
<body>
    <?php
        /* Object */
		include("../php/MySql.php");
		include("../php/LocalDefinition.php");
        include("../php/Const.php");
        include("../php/BaseClass.php");
        include("../php/Season.php");

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_GENERAL, Constants::ADMIN_MENU_2_SEASON);
            
        include("large_menu.php");
        /*include("small_menu_start.php");*/

        $mySql = new MySql();
        
        if(isset($_GET["delete"]))
        { 
            $mySql->execute("DELETE FROM season WHERE Year = " . $_GET["delete"]); 
        }

    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                <div class="row">
                    <h4>saisons</h4>
                </div>
                    <div class="row">				
                        <table id="saison" width="100%">
                            <thead>
                            <tr>
                                <th>Action</th><th>Année</th><th>Description</th><th>Courrante</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($result = $mySql->execute("SELECT * FROM season ORDER BY Year DESC")) 
                        		{                       			
                        			while ($row = $result->fetch_object("Season")) 
                        			{
                			 ?>
                                        <tr>
                            				<td>
                                                <a title="Modifier" href="season_edit.php?year=<?php echo $row->Year; ?>">
                                                    <i class="fi-page-edit size-32"> </i>
                                                </a> 
                                                 <a title="Supprimer"  
                                                   onclick="javascript:return confirm('Voulez-vous supprimer l\'enregistrement?');" 
                                                   href='season.php?delete=<?php echo $row->Year; ?>'>
                                                    <i class="fi-page-remove size-32"></i>
                                                </a>
                                            </td>
                                            <td> <?php echo $row->Year; ?> </td>
                                            <td> <?php echo $row->Name; ?> </td>
                                            <td> <?php echo $row->getIsCurrent(); ?> </td>
                                        </tr>
                             <?php          
                                    }  			
                        			$result->close();
                        		}
                            
                             ?>
                             </tbody>
                        </table>
                        <div class="paging"></div>
                    </div>
                </div>
                <div class="row">
                    <a href="season_edit.php" class="button right">Ajouter</a>
                </div>

            </section>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
    <script src="../js/datatable.min.js"></script>
    <script>
        $(document).foundation();

        $('#saison').datatable({
            pageSize: 5,
            sort: [false, true, true, false],
            filters: [false, true, true, 'select'],
            filterText: 'Filtre '
        }) ;
</script>
</body>
</html>