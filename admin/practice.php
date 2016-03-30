<!doctype html>
<?php
	// Start the session
	session_start();
?>
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
		include("../php/User.php");
		include("../php/Session.php");
        include("../php/Season.php");
        include("../php/HomeTeam.php");
        include("../php/Practice.php");
        

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_SCHEDULE, Constants::ADMIN_MENU_2_PRACTICE);
            
        include("large_menu.php");
        /*include("small_menu_start.php");*/

        $mySql = new MySql();
		
		if (isset($_SESSION[Session::C_SESSION_USER]))
		{
			$session = new Session($_SESSION[Session::C_SESSION_USER], $_SESSION[Session::C_SESSION_PASS], $mySql);
		}
		
		if (!isset($session) or ! $session->IsConnected())
		{
			header('Location: index.php');
			exit;
		}
        
        if(isset($_GET["delete"]))
        { 
            $mySql->execute("DELETE FROM practive WHERE Id = " . $_GET["delete"]); 
        }

    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                <div class="row">
                    <h4>horaire - pratique</h4>
                </div>
                    <div class="row">				
                        <table id="saison" width="100%">
                            <thead>
                            <tr>
                                <th>Action</th><th>Date</th><th>Équipe</th></th><th>Stade</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($result = $mySql->execute("SELECT p.* FROM practice AS p 
   															   INNER JOIN season AS s ON p.seasonId = s.year
															   WHERE s.IsCurrent
															   ORDER BY Date ASC")) 
                        		{                       			
                        			while ($row = $result->fetch_object("Practice")) 
                        			{
                        			     $practice = new Practice();
                                         $practice->initDB($row->Id, $mySql);
                			 ?>
                                        <tr>
                            				<td>
                                                <a title="Modifier" href="practice_edit.php?id=<?php echo $row->Id; ?>">
                                                    <i class="fi-page-edit size-32"> </i>
                                                </a> 
                                                 <a title="Supprimer"  
                                                   onclick="javascript:return confirm('Voulez-vous supprimer l\'enregistrement?');" 
                                                   href='practice.php?delete=<?php echo $row->Id; ?>'>
                                                    <i class="fi-page-remove size-32"></i>
                                                </a>
                                            </td>
                                            <td> <?php echo date("Y-m-d H:i", $row->Date); ?> </td>
                                            <td> <?php echo $practice->Team->Name; ?> </td>
                                            <td> <?php echo $practice->Stade; ?> </td>
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
                    <a href="practice_edit.php" class="button right">Ajouter</a>
                </div>

            </section>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
    <script src="../js/datatable.min.js"></script>
    <script>
        $(document).foundation();

        $('#saison').datatable({
            pageSize: 5,
            sort: [false, true, true, true],
            filters: [false, true, 'select', 'select'],
            filterText: 'Filtre '
        }) ;
</script>
</body>
</html>