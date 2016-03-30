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
        include("../php/Category.php");
        include("../php/AwayTeam.php");
        include("../php/HomeTeam.php");
        include("../php/Referee.php");
        include("../php/Marker.php");
        include("../php/Schedule.php");

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_SCHEDULE, Constants::ADMIN_MENU_2_GAME);
		
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
            
        include("large_menu.php");
        /*include("small_menu_start.php");*/        

    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                    <div class="row">
                        <h4>horaire - <?php $schedule = new Schedule();

											if (isset($_POST["date"]))
											{
												$schedule->initProperty($_POST["MyId"], 
                                                                        $_POST["seasonId"], 
                                                                        $_POST["categoryId"], 
                                                                        $_POST["teamId"],
                                                                        $_POST["awayTeamId"],
                                                                        (isset($_POST["tpHome"])) ? 1 : 0,
                                                                        strtotime($_POST["date"]),
                                                                        $_POST["stade"],
                                                                        $_POST["city"],
                                                                        $_POST["refereeId1"],
                                                                        $_POST["refereeId2"],
                                                                        $_POST["refereeId3"],
                                                                        $_POST["refereeId4"],
                                                                        $_POST["markerId1"],
                                                                        $_POST["markerId2"],
                                                                        $_POST["pointTp"],
                                                                        $_POST["pointAwayTeam"],
                                                                        $mySql);
												$schedule->PageMode = $_POST["pageMode"];
                                                $schedule->validate($mySql);
																								
												if (!$schedule->getHasError())
												{
													if ($schedule->PageMode == Constants::PAGE_MODE_EDIT)
													{
													   
														$schedule->update($mySql);
													}
													else
													{
													   
														$schedule->addNew($mySql);
													}
												}
												
												header('Location: schedule.php');
												exit;
											}
											else if (isset($_GET["id"]))
                                            {
                                                $schedule->initDB($_GET["id"], $mySql);
                                                
												echo date("Y-m-d H:i", $schedule->Date);
                                                $schedule->PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouvelle]";
                                                $schedule->PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="schedule_edit.php" id="form_schedule" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($schedule->attributeHasError('date')) { echo "class='error'";} ?>>Date
                                        <input type="datetime-local" 
                                               name="date" 
                                               value="<?php
                                                          if ($schedule->Date <> 0)
                                                          {
                                                               echo date("Y-m-d\TH:i", $schedule->Date); 
                                                          }  
                                                      ?>" 
                                        />
                                    </label>
									<?php 
										if ($schedule->attributeHasError('date')) 
										{
											echo "<small class='error'>" . $schedule->getAttributeError("date") . "</small>";
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
                                                         <?php if ($row->Year == $schedule->SeasonId) {echo "selected";} ?>> 
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
                                    <label>Catégorie
                                        <select name="categoryId">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM Category ORDER BY Id ASC"))
                                        {
                                            while ($row = $result->fetch_object("Category"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->CategoryId) {echo "selected";} ?>> 
                                                    <?php echo $row->Description; ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                    </label>
									
                                </div>
                                <div class="small-6 columns">
                                    <label>Trois-Pistoles local?
                                        <div class="switch">
                                            <input id="tphome" name="tpHome" type="checkbox" <?php if ($schedule->IsTPHome == 1) { echo "checked";} ?> /> 
                                            <label for="tphome"></label>
                                        </div> 
                                    </label>
									
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-6 columns">
                                    <label>Équipe pistoloise
                                        <select name="teamId">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM home_team ORDER BY CategoryId ASC"))
                                        {
                                            while ($row = $result->fetch_object("HomeTeam"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->TeamId) {echo "selected";} ?>> 
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
                                    <label>Équipe adverse
                                        <select name="awayTeamId">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM away_team ORDER BY CategoryId ASC"))
                                        {
                                            while ($row = $result->fetch_object("AwayTeam"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->AwayTeamId) {echo "selected";} ?>> 
                                                    <?php echo $row->getCategoryDesc($mySql) . " - " . $row->City . " - " . $row->Name; ?>
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
                                <label <?php if ($schedule->attributeHasError('pointTp')) { echo "class='error'";} ?>>Points équipe pistoloise
                                        <input type="text" name="pointTp" value="<?php echo $schedule->PointTP; ?>" />
                                    </label>
									<?php 
										if ($schedule->attributeHasError('pointTp')) 
										{
											echo "<small class='error'>" . $schedule->getAttributeError("pointTp") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($schedule->attributeHasError('pointAwayTeam')) { echo "class='error'";} ?>>Points équipe adverse
                                        <input type="text" name="pointAwayTeam" value="<?php echo $schedule->PointAwayTeam; ?>" />
                                    </label>
									<?php 
										if ($schedule->attributeHasError('pointAwayTeam')) 
										{
											echo "<small class='error'>" . $schedule->getAttributeError("pointAwayTeam") . "</small>";
										} 
									?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-6 columns">
                                <label <?php if ($schedule->attributeHasError('city')) { echo "class='error'";} ?>>Ville
                                        <input type="text" name="city" value="<?php echo $schedule->City; ?>" />
                                    </label>
									<?php 
										if ($schedule->attributeHasError('city')) 
										{
											echo "<small class='error'>" . $schedule->getAttributeError("city") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($schedule->attributeHasError('stade')) { echo "class='error'";} ?>>Stade
                                        <input type="text" name="stade" value="<?php echo $schedule->Stade; ?>" />
                                    </label>
									<?php 
										if ($schedule->attributeHasError('stade')) 
										{
											echo "<small class='error'>" . $schedule->getAttributeError("stade") . "</small>";
										} 
									?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-6 columns">
                                    <label>Marqueur 1
                                        <select name="markerId1">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM marker ORDER BY Void DESC, FirstName ASC"))
                                        {
                                            while ($row = $result->fetch_object("Marker"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->MarkerId1) {echo "selected";} ?>> 
                                                    <?php echo $row->getFullName() ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                    </label>
									
                                </div>
                                <div class="small-6 columns">
                                    <label>Marqueur 2
                                        <select name="markerId2">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM marker ORDER BY Void DESC, FirstName ASC"))
                                        {
                                            while ($row = $result->fetch_object("Marker"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->MarkerId2) {echo "selected";} ?>> 
                                                    <?php echo $row->getFullName() ?>
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
                                    <label>Arbitre 1
                                        <select name="refereeId1">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM referee ORDER BY Void DESC, FirstName ASC"))
                                        {
                                            while ($row = $result->fetch_object("Referee"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->RefereeId1) {echo "selected";} ?>> 
                                                    <?php echo $row->getFullName() ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                    </label>
									
                                </div>
                                <div class="small-6 columns">
                                    <label>Arbitre 2
                                        <select name="refereeId2">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM referee ORDER BY Void DESC, FirstName ASC"))
                                        {
                                            while ($row = $result->fetch_object("Referee"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->RefereeId2) {echo "selected";} ?>> 
                                                    <?php echo $row->getFullName() ?>
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
                                    <label>Arbitre 3
                                        <select name="refereeId3">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM referee ORDER BY Void DESC, FirstName ASC"))
                                        {
                                            while ($row = $result->fetch_object("Referee"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->RefereeId3) {echo "selected";} ?>> 
                                                    <?php echo $row->getFullName() ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                    </label>
									
                                </div>
                                <div class="small-6 columns">
                                    <label>Arbitre 4
                                        <select name="refereeId4">
                                        
                                        <?php
                                        if ($result = $mySql->execute("SELECT * FROM referee ORDER BY Void DESC, FirstName ASC"))
                                        {
                                            while ($row = $result->fetch_object("Referee"))
                                            {
                                            ?>
                                                 <option value="<?php echo $row->Id; ?>" 
                                                         <?php if ($row->Id == $schedule->RefereeId4) {echo "selected";} ?>> 
                                                    <?php echo $row->getFullName() ?>
                                                 </option>
                                            <?php
                                            }
                                        }
        
                                        ?>
                                        
                                    </select>
                                    </label>
									
                                </div>
                                
                                
                            </div>
                            <div>
                                <input type="hidden" name="MyId" value="<?php echo $schedule->Id; ?>" />
                                <input type="hidden" name="pageMode" value="<?php echo $schedule->PageMode; ?>"  />
                            </div>
                            
                            <div class="row">
                                    <div class="small-2 columns right">
                                        <a href="schedule.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_schedule').submit();" class="button right">Enregistrer</a>
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