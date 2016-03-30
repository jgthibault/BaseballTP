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
        include("../php/Coach.php");

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_GENERAL, Constants::ADMIN_MENU_2_COACH);
            
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
                        <h4>entraîneur - <?php  $coach = new Coach();
											if (isset($_POST["id"]))
											{
												$coach->initProperty($_POST["id"], $_POST["firstName"], $_POST["lastName"], $_POST["teamId"]);
												$coach->PageMode = $_POST["pageMode"];
                                                $coach->validate($mySql);
																								
												if (!$coach->getHasError())
												{
													if ($coach->PageMode == Constants::PAGE_MODE_EDIT)
													{
														$coach->update($mySql);
													}
													else
													{
														$coach->addNew($mySql);
													}
													header('Location: coach.php');
													exit;
												}
												
												echo $coach->getFullName();
											}
											else if (isset($_GET["id"]))
                                            {
                                                $coach->initDB($_GET["id"], $mySql);
                                                
												echo $coach->getFullName();
                                                $coach->PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouveau]";
                                                $coach->PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="coach_edit.php" id="form_coach" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($coach->attributeHasError('firstName')) { echo "class='error'";} ?>>Prénom
                                        <input type="text" 
                                               name="firstName" 
                                               value="<?php echo $coach->FirstName; ?>" />
                                    </label>
									<?php 
										if ($coach->attributeHasError('firstName')) 
										{
											echo "<small class='error'>" . $coach->getAttributeError("firstName") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($coach->attributeHasError('lastName')) { echo "class='error'";} ?>>Nom
                                        <input type="text" name="lastName" value="<?php echo $coach->LastName; ?>" />
                                    </label>
									<?php 
										if ($coach->attributeHasError('lastName')) 
										{
											echo "<small class='error'>" . $coach->getAttributeError("lastName") . "</small>";
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
                                                         <?php if ($row->Id == $coach->TeamId) {echo "selected";} ?>> 
                                                    <?php echo $row->Name; ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
										</select>
                                    </label>
									
                                </div>
                                
                                <input type="hidden" name="id" value="<?php echo $coach->Id; ?>" />
                                <input type="hidden" name="pageMode" value="<?php echo $coach->PageMode; ?>"  />
                            </div>
                            <div class="row">
                                    <div class="small-2 columns right">
                                        <a href="coach.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_coach').submit();" class="button right">Enregistrer</a>
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