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
    <script src="../js/datatable.min.js"></script>
</head>
<body>
    <?php
        /* Object */
		include("../php/MySql.php");
		include("../php/LocalDefinition.php");
        include("../php/Const.php");
		include("../php/User.php");
        include("../php/BaseClass.php");
		include("../php/Session.php");
		
		LocalDef::setLevelMenu(Constants::ADMIN_MENU_1_HOME, Constants::NONE);
            
        include("large_menu.php");
        
        $mySql = new MySql();
		
		if(isset($_GET["delog"]) && isset($_SESSION[Session::C_SESSION_USER]))
		{
			$session = new Session("","", $mySql);
			$session->closeSession();
		}
		
		if(isset($_POST["username"]))
		{
			$session = new Session($_POST["username"], $_POST["password"], $mySql);
		}
		else if (isset($_SESSION[Session::C_SESSION_USER]))
		{
			$session = new Session($_SESSION[Session::C_SESSION_USER], $_SESSION[Session::C_SESSION_PASS], $mySql);
		}
		else
		{
			$session = new Session("","", $mySql);
		}
        
        
    ?>
            <!-- MAIN SECTION -->
            <section class="main-section">
                <div class="small-12 columns">
                <div class="row">
                    <h4>connexion</h4>
                </div>
                    
                        <?php 
							if ($session->isConnected())
							{
						?>
								<div class="row">
									Vous êtes connecté en tant que <?php echo $session->User->UserName; ?>
								</div>
								<div class="row right">
									<div class="small-6 columns">
										<a href="index.php?delog" class="button right">Déconnecter</a>
									</div> 
								</div>  
						<?php		
							}
							else
							{
								?>
								<form action="index.php" id="form_login" method="post">
									<div class="row">				
										<div class="small-6 columns">
											<label>Nom d'utilisateur
												<input type="text" name="username" />
											</label>									
										</div>
										<div class="small-6 columns">
											<label>Mot de passe
												<input type="password" name="password" />
											</label>																		
										</div>
									</div>
									<div class="row">
										<div class="small-6 columns right">
											<a href="javascript:;" onclick="document.getElementById('form_login').submit();" class="button right">Connecter</a>
										</div> 
									
									</div>  
								</div>
								<?php
							}	
							
						?>
                        <div class="paging"></div>
                </div>
            </section>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
    <script>
        $(document).foundation();
</script>
</body>
</html>