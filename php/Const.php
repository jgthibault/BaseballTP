<?php

class Constants
{
	const NONE = 0;
	
	//First level menus
	const ADMIN_MENU_1_GENERAL = 1;
    const ADMIN_MENU_1_TEAM = 2;
    const ADMIN_MENU_1_SCHEDULE = 3;
	
	//Second level menus
    //Général
	const ADMIN_MENU_2_SEASON = 1;
    const ADMIN_MENU_2_REFEREE = 2;
    const ADMIN_MENU_2_MARKER = 3;
    const ADMIN_MENU_2_COACH = 4;
    
    //Équipe
    const ADMIN_MENU_2_HOME_TEAM = 1;
    const ADMIN_MENU_2_AWAY_TEAM = 2;

    const ADMIN_MENU_2_GAME = 1;
    const ADMIN_MENU_2_PRACTICE = 2;    
	
    //Page mode
    const PAGE_MODE_ADD = 1;
    const PAGE_MODE_EDIT = 2;
    const PAGE_MODE_NONE = 0;
}

?>