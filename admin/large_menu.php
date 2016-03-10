<!-- For medium screen -->
<section class="navigation-section">

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
                                <li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_REFEREE); ?>"><a href="referee.php">Arbitres</a></li>
                                <li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_MARKER); ?>"><a href="marker.php">Marqueurs</a></li>
							</ul>
						</li>
                        <li class="has-dropdown <?php echo LocalDef::isFirstActive(Constants::ADMIN_MENU_1_TEAM); ?>">
                            <a href="#">Équipes</a>
                            <ul class="dropdown">
								<li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_HOME_TEAM); ?>"><a href="home_team.php">Trois-Pistoles</a></li>
                                <li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_AWAY_TEAM); ?>"><a href="away_team.php">Adversaires</a></li>
							</ul>
                        </li>
                        <li class="has-dropdown <?php echo LocalDef::isFirstActive(Constants::ADMIN_MENU_1_SCHEDULE); ?>">
                            <a href="#">Horaire</a>
                            <ul class="dropdown">
								<li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_GAME); ?>"><a href="schedule.php">Match</a></li>
                                <li class="<?php echo LocalDef::isSecondActive(Constants::ADMIN_MENU_2_PRACTICE); ?>"><a href="practice.php">Pratique</a></li>
							</ul>
                        </li>
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