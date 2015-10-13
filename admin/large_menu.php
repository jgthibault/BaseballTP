<!-- For medium screen -->
<section class="navigation-section show-for-medium-up">

    <div>

        <div class="columns">

            <!-- TOP BAR INITIALIZATION -->
            <nav class="top-bar" data-topbar>
                <ul class="title-area">
                    <li class="name">
                        
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                </ul>

                <!-- TOP BAR MENU ELEMENTS -->
                <section class="top-bar-section">
                    <!-- Right Nav Section -->
                    <ul class="right">
						<li class="has-dropdown <?php echo LocalDef::isFirstActive(Constants::ADMIN_MENU_1_GENERAL); ?>">
							<a href="#">Général</a>
							<ul class="dropdown">
								<li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_SEASON); ?>"><a href="season.php">Saison</a></li>
                                <li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_REFEREE); ?>"><a href="referee.php">Arbitre</a></li>
							</ul>
						</li>
                        <li><a href="standing.php">Équipes</a></li>
                        <li><a href="teams.php">Arbitres</a></li>
						<li><a href="tournement.php">Tournoi</a></li>
                    </ul>

                    <!-- Left Nav Section -->
                    <ul class="left">
                        <li>
                            <a href="#"></a>
                        </li>
                    </ul>
                </section>
            </nav>

        </div>
    </div>
</section>