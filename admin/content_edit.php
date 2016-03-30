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
		include("../php/Content.php");
		
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
		
		$content = new Content();
		$content->PageMode = Constants::PAGE_MODE_EDIT;
		$currentPage = Constants::ADMIN_MENU_2_HOME;
		if (isset($_GET["page"]))
		{
			$content->initDB($_GET["page"], $mySql);
			
			if ($_GET["page"] == Constants::PAGE_CONTENT_JOIN)
			{
				$currentPage = Constants::ADMIN_MENU_2_JOIN;
			}
			else if ($_GET["page"] == Constants::PAGE_CONTENT_STAFF)
			{
				$currentPage = Constants::ADMIN_MENU_2_STAFF;
			}
		}
		else
		{
			$content->initDB(Constants::PAGE_CONTENT_HOME, $mySql);
		}
        
        LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_CONTENT, $currentPage);
            
        include("large_menu.php");
        /*include("small_menu_start.php");*/       
        
    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                    <div class="row">
                        <h4>contenu - <?php 
											if (isset($_POST["id"]))
											{
												$content->initProperty($_POST["id"], $currentPage, $_POST["code"]);
												$content->validate($mySql);
																								
												if (!$content->getHasError())
												{
													if ($content->PageMode == Constants::PAGE_MODE_EDIT)
													{
														$content->update($mySql);
													}
												}
												
												echo $content->PageName;
											}
											else
                                            {
												echo $content->PageName;
                                            }

                                      ?>
                        </h4>
                    </div>
                    <div class="row">					
                        <form action="content_edit.php" id="form_content" method="post">
                            <div class="row">
                                <div class="small-12 columns">
                                    <label <?php if ($content->attributeHasError('code')) { echo "class='error'";} ?>>
                                        <textarea name="code" rows="20"><?php echo $content->Code; ?></textarea>
                                    </label>
									<?php 
										if ($content->attributeHasError('code')) 
										{
											echo "<small class='error'>" . $content->getAttributeError("code") . "</small>";
										} 
									?>
									
                                </div>
								
								<input type="hidden" name="id" value="<?php echo $content->Id; ?>" />
                            </div>
                            <div class="row">
								<div class="small-2 columns right">
									<a href="javascript:;" onclick="document.getElementById('form_content').submit();" class="button right">Enregistrer</a>
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