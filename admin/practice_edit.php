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
        include("../php/Season.php");
        include("../php/HomeTeam.php");
		include("../php/Category.php");
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
    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                    <div class="row">
                        <h4>horaire - <?php $practice = new Practice();

											if (isset($_POST["date"]))
											{
												$practice->initProperty($_POST["MyId"], 
                                                                        $_POST["seasonId"], 
                                                                        $_POST["teamId"],
                                                                        strtotime($_POST["date"]),
                                                                        $_POST["stade"],
                                                                        $mySql);
												$practice->PageMode = $_POST["pageMode"];
                                                $practice->validate($mySql);
																								
												if (!$practice->getHasError())
												{
													if ($practice->PageMode == Constants::PAGE_MODE_EDIT)
													{
													   
														$practice->update($mySql);
													}
													else
													{
													   
														$practice->addNew($mySql);
													}
												}
												
												header('Location: practice.php');
												exit;
											}
											else if (isset($_GET["id"]))
                                            {
                                                $practice->initDB($_GET["id"], $mySql);
                                                
												echo date("Y-m-d H:i", $practice->Date);
                                                $practice->PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouvelle]";
                                                $practice->PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="practice_edit.php" id="form_practice" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($practice->attributeHasError('date')) { echo "class='error'";} ?>>Date
                                        <input type="datetime-local" 
                                               name="date" 
                                               value="<?php
                                                          if ($practice->Date <> 0)
                                                          {
                                                               echo date("Y-m-d\TH:i", $practice->Date); 
                                                          }  
                                                      ?>" 
                                        />
                                    </label>
									<?php 
										if ($practice->attributeHasError('date')) 
										{
											echo "<small class='error'>" . $practice->getAttributeError("date") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label>Saison
                                        <select name="seasonId">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM Season ORDER BY IsCurrent DESC, Year DESC"))
                                        {
                                            while ($row = $result->fetch_object("Season"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Year; ?>" 
                                                         <?php if ($row->Year == $practice->SeasonId) {echo "selected";} ?>> 
                                                    <?php echo $row->Year . " - " . $row->Name; ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                    </label>
									
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
                                                         <?php if ($row->Id == $practice->TeamId) {echo "selected";} ?>> 
                                                    <?php echo $row->getCategoryDesc($mySql) . " - " . $row->Name; ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                    </label>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($practice->attributeHasError('stade')) { echo "class='error'";} ?>>Stade
                                        <input type="text" name="stade" value="<?php echo $practice->Stade; ?>" />
                                    </label>
									<?php 
										if ($practice->attributeHasError('stade')) 
										{
											echo "<small class='error'>" . $practice->getAttributeError("stade") . "</small>";
										} 
									?>
                                </div>
                            </div>
                            <div class="row">
                                
                            </div>
                            
                            <div>
                                <input type="hidden" name="MyId" value="<?php echo $practice->Id; ?>" />
                                <input type="hidden" name="pageMode" value="<?php echo $practice->PageMode; ?>"  />
                            </div>
                            
                            <div class="row">
                                    <div class="small-2 columns right">
                                        <a href="practice.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_practice').submit();" class="button right">Enregistrer</a>
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