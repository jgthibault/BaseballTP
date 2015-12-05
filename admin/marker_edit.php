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
        include("../php/Marker.php");

        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_GENERAL, Constants::ADMIN_MENU_2_MARKER);
            
        include("large_menu.php");
        /*include("small_menu_start.php");*/

        $mySql = new MySql();
        

    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                    <div class="row">
                        <h4>marqueur - <?php  $marker = new Marker();
											if (isset($_POST["id"]))
											{
												$marker->initProperty($_POST["id"], $_POST["firstName"], $_POST["lastName"], strtotime($_POST["birth"]));
												$marker->PageMode = $_POST["pageMode"];
                                                $marker->validate($mySql);
																								
												if (!$marker->getHasError())
												{
													if ($marker->PageMode == Constants::PAGE_MODE_EDIT)
													{
														$marker->update($mySql);
													}
													else
													{
														$marker->addNew($mySql);
													}
													header('Location: marker.php');
													exit;
												}
												
												echo $marker->getFullName();
											}
											else if (isset($_GET["id"]))
                                            {
                                                $marker->initDB($_GET["id"], $mySql);
                                                
												echo $marker->getFullName();
                                                $marker->PageMode = Constants::PAGE_MODE_EDIT;
                                            }
                                            else
                                            {
                                                echo "[Nouveau]";
                                                $marker->PageMode = Constants::PAGE_MODE_ADD;
                                            }
                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="marker_edit.php" id="form_marker" method="post">
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($marker->attributeHasError('firstName')) { echo "class='error'";} ?>>Prénom
                                        <input type="text" 
                                               name="firstName" 
                                               value="<?php echo $marker->FirstName; ?>" />
                                    </label>
									<?php 
										if ($marker->attributeHasError('firstName')) 
										{
											echo "<small class='error'>" . $marker->getAttributeError("firstName") . "</small>";
										} 
									?>
									
                                </div>
                                <div class="small-6 columns">
                                    <label <?php if ($marker->attributeHasError('lastName')) { echo "class='error'";} ?>>Nom
                                        <input type="text" name="lastName" value="<?php echo $marker->LastName; ?>" />
                                    </label>
									<?php 
										if ($marker->attributeHasError('lastName')) 
										{
											echo "<small class='error'>" . $marker->getAttributeError("lastName") . "</small>";
										} 
									?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-6 columns">
                                    <label <?php if ($marker->attributeHasError('birth')) { echo "class='error'";} ?>>Date de naisance
                                        <input type="date" 
                                               name="birth" 
                                               value="<?php echo  $marker->Birth; ?>" />
                                    </label>
									<?php 
										if ($marker->attributeHasError('birth')) 
										{
											echo "<small class='error'>" . $marker->getAttributeError("birth") . "</small>";
										} 
									?>
									
                                </div>
                                
                                
                                <input type="hidden" name="id" value="<?php echo $marker->Id; ?>" />
                                <input type="hidden" name="pageMode" value="<?php echo $marker->PageMode; ?>"  />
                            </div>
                            <div class="row">
                                    <div class="small-2 columns right">
                                        <a href="season.php" class="button right">Annuler</a>
                                    </div>
                                    <div class="small-2 columns right">
                                        <a href="javascript:;" onclick="document.getElementById('form_marker').submit();" class="button right">Enregistrer</a>
                                    </div> 
                                
                            </div>  
                        </form>                        
                    </div>
                </div>
            </section>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
</body>
</html>