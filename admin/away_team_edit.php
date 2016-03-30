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
        include("../php/Category.php");
        include("../php/AwayTeam.php");

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_TEAM, Constants::ADMIN_MENU_2_AWAY_TEAM);
            
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
                        <h4>équipe adverse - <?php  $team = new AwayTeam();
											if (isset($_POST["id"]))
											{
												$team->initProperty($_POST["id"], $_POST["name"], $_POST["categoryId"], $_POST["city"]);
												$team->PageMode = $_POST["pageMode"];
                                                $team->validate($mySql);
																								
												if (!$team->getHasError())
												{
													if ($team->PageMode == Constants::PAGE_MODE_EDIT)
													{
														$team->update($mySql);
													}
													else
													{
														$team->addNew($mySql);
													}
													header('Location: away_team.php');
													exit;
												}
												
												echo $team->Name;
											}
											else if (isset($_GET["id"]))
                                            {
                                                $team->initDB($_GET["id"], $mySql);
                                                
												echo $team->Name;
                                                $team->PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouvelle]";
                                                $team->PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="away_team_edit.php" id="form_away_team" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($team->attributeHasError('name')) { echo "class='error'";} ?>>Nom
                                        <input type="text" 
                                               name="name" 
                                               value="<?php echo $team->Name; ?>" />
                                    </label>
									<?php 
										if ($team->attributeHasError('name')) 
										{
											echo "<small class='error'>" . $team->getAttributeError("name") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label>Catégorie
                                    <select name="categoryId">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM Category ORDER BY Id"))
                                        {
                                            while ($row = $result->fetch_object("Category"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $team->CategoryId) {echo "selected";} ?>> 
                                                    <?php echo $row->Description; ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($team->attributeHasError('city')) { echo "class='error'";} ?>>Ville
                                        <input type="text" 
                                               name="city" 
                                               value="<?php echo $team->City; ?>" />
                                    </label>
									<?php 
										if ($team->attributeHasError('city')) 
										{
											echo "<small class='error'>" . $team->getAttributeError("city") . "</small>";
										} 
									?>
									
                                </div>
                            </div>
                            <div class="row">                             
                                <input type="hidden" name="id" value="<?php echo $team->Id; ?>" />
                                <input type="hidden" name="pageMode" value="<?php echo $team->PageMode; ?>"  />
                            </div>
                            <div class="row">
                                    <div class="small-2 columns right">
                                        <a href="away_team.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_away_team').submit();" class="button right">Enregistrer</a>
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