<?php

class Schedule extends BaseClass
{
    public $SeasonId = 0;
    public $Season;
    
    public $CategoryId = 0;
    public $Category;
    
    public $TeamId = 0;
    public $Team;
    
    public $AwayTeamId = 0;
    public $AwayTeam;
    
    public $IsTPHome = false;
    public $Date;
    public $Stade;
    public $City;
    public $Id;
    
    public $RefereeId1 = 0;
    public $Referee1;
    
    public $RefereeId2 = 0;
    public $Referee2;
    
    public $RefereeId3 = 0;
    public $Referee3;
    
    public $RefereeId4 = 0;
    public $Referee4;
    
    public $MarkerId1 = 0;
    public $Marker1;
    
    public $MarkerId2 = 0;
    public $Marker2;
    
    public $PointTP = 0;
    public $PointAwayTeam = 0; 
            
    function __construct()
    {
		
	}
    
    public function initProperty($id, $seasonId, $categoryId, $teamId, $awayTeamId, $isTPHome, $date, $stade, $city, $refereeId1, $refereeId2, $refereeId3, $refereeId4, $markerId1, $markerId2, $pointTP, $pointAwayTeam,s $mysql)
    {   
        $this->setProperty($id, $seasonId, $categoryId, $teamId, $awayTeamId, $isTPHome, $date, $stade, $city, $refereeId1, $refereeId2, $refereeId3, $refereeId4, $markerId1, $markerId2, $pointTP, $pointAwayTeam);
        $this->loadObject($mysql);         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM schedule WHERE id = " . $id);
        $row = $result->fetch_object("Schedule");
        
        $this->setProperty($row->Id, 
                           $row->SeasonId, 
                           $row->CategoryId, 
                           $row->TeamId, 
                           $row->AwayTeamId, 
                           $row->IsTPHome, 
                           $row->Date, 
                           $row->Stade, 
                           $row->City,
                           $row->RefereeId1,
                           $row->RefereeId2,
                           $row->RefereeId3,
                           $row->RefereeId4,
                           $row->MarkerId1,
                           $row->MarkerId2,
                           $row->PointTP,
                           $row->PointAwayTeam);
        $this->loadObject($mysql);        
    }
    
    private function loadObject($mysql)
    {
        //season
        if ($this->SeasonId <> 0)
        {
            $result = $mysql->execute("SELECT * FROM season WHERE Id = " . $this->SeasonId);
            $this->Season = $result->fetch_object("Season");
        }
        
        //catégorie
        if ($this->CategoryId <> 0)
        {
            $result = $mysql->execute("SELECT * FROM category WHERE Id = " . $this->CategoryId);
            $this->Category = $result->fetch_object("Category");
        }
        
        //team
        if ($this->TeamId <> 0)
        {
            $result = $mysql->execute("SELECT * FROM home_team WHERE Id = " . $this->TeamId);
            $this->Team = $result->fetch_object("HomeTeam");
        }
        
        //away team
        if ($this->AwayTeamId <> 0)
        {
            $result = $mysql->execute("SELECT * FROM away_team WHERE Id = " . $this->AwayTeamId);
            $this->AwayTeam = $result->fetch_object("AwayTeam");
        }
        
        //referee 1
        if ($this->RefereeId1 <> 0)
        {
            $result = $mysql->execute("SELECT * FROM referee WHERE Id = " . $this->RefereeId1);
            $this->Referee1 = $result->fetch_object("Referee");
        }
        
        //referee 2
        if ($this->RefereeId2 <> 0)
        {
            $result = $mysql->execute("SELECT * FROM referee WHERE Id = " . $this->RefereeId2);
            $this->Referee2 = $result->fetch_object("Referee");
        }
        
        //referee 3
        if ($this->RefereeId3 <> 0)
        {
            $result = $mysql->execute("SELECT * FROM referee WHERE Id = " . $this->RefereeId3);
            $this->Referee3 = $result->fetch_object("Referee");
        }
        
        //referee 4
        if ($this->RefereeId4 <> 0)
        {
            $result = $mysql->execute("SELECT * FROM referee WHERE Id = " . $this->RefereeId4);
            $this->Referee4 = $result->fetch_object("Referee");
        }
        
        //marker 1
        if ($this->MarkerId1 <> 0)
        {
            $result = $mysql->execute("SELECT * FROM marker WHERE Id = " . $this->MarkerId1);
            $this->Marker1 = $result->fetch_object("Marker");
        }
        
        //marker 2
        if ($this->MarkerId2 <> 0)
        {
            $result = $mysql->execute("SELECT * FROM marker WHERE Id = " . $this->MarkerId2);
            $this->Marker2 = $result->fetch_object("Marker");
        }
    }
    
    private function setProperty($id, $seasonId, $categoryId, $teamId, $awayTeamId, $isTPHome, $date, $stade, $city, $refereeId1, $refereeId2, $refereeId3, $refereeId4, $markerId1, $markerId2, $pointTP, $pointAwayTeam)
    {
        $this->SeasonId = $seasonId;
        $this->CategoryId = $categoryId;
        $this->Id = $id;
        $this->TeamId = $teamId;
        $this->AwayTeamId = $awayTeamId;
        $this->IsTPHome = $isTPHome;
        $this->Date = $date;
        $this->Stade = $stade;
        $this->City = $city;
        $this->RefereeId1 = $refereeId1;
        $this->RefereeId2 = $refereeId2;
        $this->RefereeId3 = $refereeId3;
        $this->RefereeId4 = $refereeId4;
        $this->MarkerId1 = $markerId1;
        $this->MarkerId2 = $markerId2;
        $this->PointTP   = $pointTP;
        $this->PointAwayTeam   = $pointAwayTeam;
        		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("seasonId" => "",
                                    "categoryId" => "",
                                    "teamId" => "", 
                                    "awayTeamId" => "",
                                    "date" => "",
                                    "stade" => "",
                                    "city" => "",
                                    "refereeId1" => "",
                                    "refereeId2" => "",
                                    "refereeId3" => "",
                                    "refereeId4" => "",
                                    "markerId1" => "",
                                    "markerId2" => "",);
	}
    
    public function validate($mySql)
    {
		$this->initValueState();
        		
		if ($this->SeasonId = 0)
		{
			$this->m_valueState["seasonId"] = "La saison est obligatoire.";
		}
        
        if ($this->CategoryId = 0)
		{
			$this->m_valueState["categoryId"] = "La catégorie est obligatoire.";
		}
        
        if ($this->TeamId = 0)
		{
			$this->m_valueState["teamId"] = "L'équipe pistoloise est obligatoire.";
		}
        
        if ($this->AwayTeamId = 0)
		{
			$this->m_valueState["awayTeamId"] = "L'équipe adverse est obligatoire.";
		}
        
        if (strlen($this->Stade) > 75)
        {
            $this->m_valueState["stade"] = "Le stade ne peut déapasser 75 caractères.";
        }
        
        if (strlen($this->City) > 75)
        {
            $this->m_valueState["city"] = "Le ville ne peut dépasser 75 caractères.";
        }

    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE schedule SET SeasonId = ?, 
                                             CategoryId = ?, 
                                             TeamId = ?, 
                                             IsTPHome = ?, 
                                             AwayTeamId = ?, 
                                             Date = ?, 
                                             stade = ?, 
                                             city = ?,
                                             MarkerId1 = ?,
                                             MarkerId2 = ?,
                                             ScheduleId1 = ?,
                                             ScheduleId2 = ?,
                                             ScheduleId3 = ?,
                                             ScheduleId4 = ?,
                                             PointTP = ?,
                                             PointAwayTeam = ?,
                                         WHERE Id = ?", 
                        array("iiiiiissiiiiiiiii", 
                              $this->SeasonId, 
							  $this->CategoryId,
                              $this->TeamId,
                              $this->IsTPHome,
                              $this->AwayTeamId,
                              $this->Date,
                              $this->stade,
                              $this->city,
                              $this->MarkerId1,
                              $this->MarkerId2,
                              $this->RefereeId1,
                              $this->RefereeId2,
                              $this->RefereeId3,
                              $this->RefereeId4,
                              $this->PointTP,
                              $this->PointAwayTeam,                       
							  $this->Id));
	}
	
	public function addNew($mySql)
	{
	    $mySql->prepare("INSERT INTO schedule (SeasonId, 
                                               CategoryId, 
                                               TeamId, 
                                               IsTPHome, 
                                               AwayTeamId, 
                                               Date, 
                                               stade, 
                                               city, 
                                               MarkerId1, 
                                               MarkerId2, 
                                               ScheduleId1, 
                                               ScheduleId2, 
                                               ScheduleId3, 
                                               ScheduleId4,
                                               PointTP,
                                               PointAwayTeam ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
                        array("iiiiiissiiiiiiii",
                              $this->SeasonId, 
							  $this->CategoryId,
                              $this->TeamId,
                              $this->IsTPHome,
                              $this->AwayTeamId,
                              $this->Date,
                              $this->stade,
                              $this->city,
                              $this->MarkerId1,
                              $this->MarkerId2,
                              $this->RefereeId1,
                              $this->RefereeId2,
                              $this->RefereeId3,
                              $this->RefereeId4,
                              $this->PointTP,
                              $this->PointAwayTeam));                                                                                         
	}
} 
?>