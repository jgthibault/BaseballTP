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
        

    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                    <div class="row">
                        <h4>saison - <?php  $season = new Season();
											if (isset($_POST["year"]))
											{
												$season->initProperty($_POST["year"], $_POST["name"], (isset($_POST["isCurrent"]) ? $_POST["isCurrent"] : false));
												$season->validate($mySql);
												
												if (!$season->getHasError())
												{
													if (Season::$PageMode == Constants::PAGE_MODE_EDIT)
													{
													   
														$stmt = $mySql->prepare("UPDATE season SET season = ?, name = ?, iscurrent = ? WHERE");
                                                        $mySql->bind($stmt, "iii", array($_POST["year"], 
                                                                                         $_POST["name"], 
                                                                                         (isset($_POST["isCurrent"]) ? $_POST["isCurrent"] : false)));
                                                        $stmt->execute();
                                                        $stmt->close(); 
													}
													else
													{
														
													}
												}
												
												echo $season->Year;
											}
											else if (isset($_GET["year"]))
                                            {
                                                $season->initDB($_GET["year"], $mySql);
                                                
												echo $season->Year;
                                                Season::$PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouvelle]";
                                                Season::$PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="season_edit.php" id="form_season" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($season->attributeHasError('year')) { echo "class='error'";} ?>>Année
                                        <input type="text" name="year" value="<?php echo $season->Year; ?>" />
                                    </label>
									<?php 
										if ($season->attributeHasError('year')) 
										{
											echo "<small class='error'>" . $season->getAttributeError("year") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($season->attributeHasError('name')) { echo "class='error'";} ?>>Nom
                                        <input type="text" name="name" value="<?php echo $season->Name; ?>" />
                                    </label>
									<?php 
										if ($season->attributeHasError('name')) 
										{
											echo "<small class='error'>" . $season->getAttributeError("year") . "</small>";
										} 
									?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-6 columns">
                                    <label>Saison courante
                                        <div class="switch">
                                            <input id="test" name="isCurrent" type="checkbox" <?php if ($season->IsCurrent) { echo "checked";} ?> /> 
                                            <label for="test"></label>
                                        </div> 
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                
                                    <div class="small-2 columns right">
                                        <a href="season.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_season').submit();" class="button right">Enregistrer</a>
                                    </div> 
                                
                            </div>  
                        </form>                        
                    </div>
                </div>
            </section>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/datatable.min.js"></script>
    <script>
        $(document).foundation();

        $('#saison').datatable({
            pageSize: 5,
            sort: [true, true, true,true,true],
            filters: [true, true, 'select', true, true],
            filterText: 'Filtre '
        }) ;
</script>
</body>
</html>