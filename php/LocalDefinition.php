<?php

class LocalDef
{
	protected static $FirstLevelMenu;
	protected static $SecondLevelMenu;
	
	public static function setLevelMenu($firstLevel, $secondLevel)
	{
		self::$FirstLevelMenu = $firstLevel;
		self::$SecondLevelMenu = $secondLevel;	
		
	}
	
	public static function isFirstActive($level)
	{
		if ($level == self::$FirstLevelMenu) { return "active"; }		
	}
	
	public static function isSecondActive($firstLevel, $secondLevel)
	{
		if ($firstLevel == self::$FirstLevelMenu && $secondLevel == self::$SecondLevelMenu) { return "active"; }		
	}
}
?>