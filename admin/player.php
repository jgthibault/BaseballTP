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
        include("../php/HomeTeam.php");
		include("../php/Player.php");
        

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_GENERAL, Constants::ADMIN_MENU_2_PLAYER);
            
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
            $mySql->execute("DELETE FROM player WHERE Id = " . $_GET["delete"]);
        }

    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                <div class="row">
                    <h4>joueurs</h4>
                </div>
                    <div class="row">					
                        <table id="Player" width="100%">
                            <thead>
                            <tr>
                                <th>Action</th><th>Prénom</th><th>Nom de famille</th><th>Équipe</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($result = $mySql->execute("SELECT * FROM player ORDER BY LastName")) 
                        		{                       			
                        			while ($row = $result->fetch_object("Player")) 
                        			{
                			 ?>
                                        <tr>
                            				<td>
                                                <a title="Modifier" href="player_edit.php?id=<?php echo $row->Id; ?>">
                                                    <i class="fi-page-edit size-32"> </i>
                                                </a> 
                                                <a title="Supprimer" 
                                                    href="player.php?delete=<?php echo $row->Id; ?>"
                                                    onclick="return confirm('Voulez-vous supprimer l\'enregistrement?');">
                                                    <i class="fi-page-remove size-32"></i>
                                                </a>
                                            </td>
                                            <td> <?php echo $row->FirstName; ?> </td>
                                            <td> <?php echo $row->LastName; ?> </td>
											<td> <?php echo $row->getTeamName($mySql); ?> </td>
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
                    <a href="player_edit.php" class="button right">Ajouter</a>
                </div>

            </section>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
    <script src="../js/datatable.min.js"></script>
    <script>
        $(document).foundation();

        $('#Player').datatable({
            pageSize: 15,
            sort: [false, true, true, true],
            filters: [false, true, true, 'select'],
            filterText: 'Filtre '
        }) ;
</script>
</body>
</html>