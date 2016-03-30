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
    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                    <div class="row">
                        <h4>joueur - <?php  $player = new Player();
											if (isset($_POST["id"]))
											{
												$player->initProperty($_POST["id"], $_POST["firstName"], $_POST["lastName"], $_POST["teamId"]);
												$player->PageMode = $_POST["pageMode"];
                                                $player->validate($mySql);
																								
												if (!$player->getHasError())
												{
													if ($player->PageMode == Constants::PAGE_MODE_EDIT)
													{
														$player->update($mySql);
													}
													else
													{
														$player->addNew($mySql);
													}
													header('Location: player.php');
													exit;
												}
												
												echo $player->getFullName();
											}
											else if (isset($_GET["id"]))
                                            {
                                                $player->initDB($_GET["id"], $mySql);
                                                
												echo $player->getFullName();
                                                $player->PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouveau]";
                                                $player->PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="player_edit.php" id="form_player" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($player->attributeHasError('firstName')) { echo "class='error'";} ?>>Prénom
                                        <input type="text" 
                                               name="firstName" 
                                               value="<?php echo $player->FirstName; ?>" />
                                    </label>
									<?php 
										if ($player->attributeHasError('firstName')) 
										{
											echo "<small class='error'>" . $player->getAttributeError("firstName") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($player->attributeHasError('lastName')) { echo "class='error'";} ?>>Nom
                                        <input type="text" name="lastName" value="<?php echo $player->LastName; ?>" />
                                    </label>
									<?php 
										if ($player->attributeHasError('lastName')) 
										{
											echo "<small class='error'>" . $player->getAttributeError("lastName") . "</small>";
										} 
									?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-6 columns">
                                    <label>Équipe
                                        <select name="teamId">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM home_team ORDER BY CategoryId ASC"))
                                        {
                                            while ($row = $result->fetch_object("HomeTeam"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $player->TeamId) {echo "selected";} ?>> 
                                                    <?php echo $row->Name; ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
										</select>
                                    </label>
									
                                </div>
                                
                                <input type="hidden" name="id" value="<?php echo $player->Id; ?>" />
                                <input type="hidden" name="pageMode" value="<?php echo $player->PageMode; ?>"  />
                            </div>
                            <div class="row">
                                    <div class="small-2 columns right">
                                        <a href="player.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_player').submit();" class="button right">Enregistrer</a>
                                    </div> 
                                
                            </div>  
                        </form>                        
                    </div>
                </div>
            </section>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>
</html>