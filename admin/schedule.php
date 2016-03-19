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
        include("../php/Category.php");
        include("../php/AwayTeam.php");
        include("../php/HomeTeam.php");
        include("../php/Referee.php");
        include("../php/Marker.php");
        include("../php/Schedule.php");
        

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_SCHEDULE, Constants::ADMIN_MENU_2_GAME);
            
        include("large_menu.php");
        /*include("small_menu_start.php");*/

        $mySql = new MySql();
        
        if(isset($_GET["delete"]))
        { 
            $mySql->execute("DELETE FROM schedule WHERE Id = " . $_GET["delete"]); 
        }

    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                <div class="row">
                    <h4>horaire</h4>
                </div>
                    <div class="row">				
                        <table id="saison" width="100%">
                            <thead>
                            <tr>
                                <th>Action</th><th>Date</th><th>Catégorie</th></th><th>Équipe pistoloise</th><th>Équipe adversaire</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($result = $mySql->execute("SELECT * FROM schedule ORDER BY Date ASC")) 
                        		{                       			
                        			while ($row = $result->fetch_object("Schedule")) 
                        			{
                        			     $schedule = new Schedule();
                                         $schedule->initDB($row->Id, $mySql);
                			 ?>
                                        <tr>
                            				<td>
                                                <a title="Modifier" href="schedule_edit.php?id=<?php echo $row->Id; ?>">
                                                    <i class="fi-page-edit size-32"> </i>
                                                </a> 
                                                 <a title="Supprimer"  
                                                   onclick="javascript:return confirm('Voulez-vous supprimer l\'enregistrement?');" 
                                                   href='schedule.php?delete=<?php echo $row->Id; ?>'>
                                                    <i class="fi-page-remove size-32"></i>
                                                </a>
                                            </td>
                                            <td> <?php echo date("Y-m-d", $row->Date); ?> </td>
                                            <td> <?php echo $schedule->Category->Description; ?> </td>
                                            <td> <?php echo $schedule->Team->Name; ?> </td>
                                            <td> <?php echo $schedule->AwayTeam->getNameCity(); ?> </td>
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
                    <a href="schedule_edit.php" class="button right">Ajouter</a>
                </div>

            </section>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
    <script src="../js/datatable.min.js"></script>
    <script>
        $(document).foundation();

        $('#saison').datatable({
            pageSize: 5,
            sort: [false, true, true, true, true],
            filters: [false, true, 'select', 'select', 'select', ],
            filterText: 'Filtre '
        }) ;
</script>
</body>
</html>