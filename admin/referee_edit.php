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
        include("../php/Referee.php");

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_GENERAL, Constants::ADMIN_MENU_2_REFEREE);
            
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
                        <h4>arbitre - <?php  $referee = new Referee();
											if (isset($_POST["id"]))
											{
												$referee->initProperty($_POST["id"], $_POST["firstName"], $_POST["lastName"]);
												$referee->PageMode = $_POST["pageMode"];
                                                $referee->validate($mySql);
																								
												if (!$referee->getHasError())
												{
													if ($referee->PageMode == Constants::PAGE_MODE_EDIT)
													{
														$referee->update($mySql);
													}
													else
													{
														$referee->addNew($mySql);
													}
													header('Location: referee.php');
													exit;
												}
												
												echo $referee->getFullName();
											}
											else if (isset($_GET["id"]))
                                            {
                                                $referee->initDB($_GET["id"], $mySql);
                                                
												echo $referee->getFullName();
                                                $referee->PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouveau]";
                                                $referee->PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="referee_edit.php" id="form_referee" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($referee->attributeHasError('firstName')) { echo "class='error'";} ?>>Prénom
                                        <input type="text" 
                                               name="firstName" 
                                               value="<?php echo $referee->FirstName; ?>" />
                                    </label>
									<?php 
										if ($referee->attributeHasError('firstName')) 
										{
											echo "<small class='error'>" . $referee->getAttributeError("firstName") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($referee->attributeHasError('lastName')) { echo "class='error'";} ?>>Nom
                                        <input type="text" name="lastName" value="<?php echo $referee->LastName; ?>" />
                                    </label>
									<?php 
										if ($referee->attributeHasError('lastName')) 
										{
											echo "<small class='error'>" . $referee->getAttributeError("lastName") . "</small>";
										} 
									?>
                                </div>
                                
                                <input type="hidden" name="id" value="<?php echo $referee->Id; ?>" />
                                <input type="hidden" name="pageMode" value="<?php echo $referee->PageMode; ?>"  />
                            </div>
                            <div class="row">
                                    <div class="small-2 columns right">
                                        <a href="season.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_referee').submit();" class="button right">Enregistrer</a>
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