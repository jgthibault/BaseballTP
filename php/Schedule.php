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
            
    function __construct()
    {
		
	}
    
    public function initProperty($id, $seasonId, $categoryId, $teamId, $awayTeamId, $isTPHome, $date, $stade, $city, $mysql)
    {   
        $this->setProperty($id, $seasonId, $categoryId, $teamId, $awayTeamId, $isTPHome, $date, $stade, $city);
        $this->loadObject($mysql);         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM schedule WHERE id = " . $id);
        $row = $result->fetch_object("Schedule");
        
        $this->setProperty($row->Id, $row->SeasonId, $row->CategoryId, $row->TeamId, $row->AwayTeamId, $row->IsTPHome, $row->Date, $row->Stade, $row->City);
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
    }
    
    private function setProperty($id, $seasonId, $categoryId, $teamId, $awayTeamId, $isTPHome, $date, $stade, $city)
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
                                    "city" => "",);
	}
    
    public function validate($mySql)
    {
		$this->initValueState();
        		
		if (strlen($this->Name) > 100)
		{
			$this->m_valueState["name"] = "Le nom ne peut dépasser 100 caractères.";
		}
		else if (strlen($this->Name) == 0)
		{
			$this->m_valueState["name"] = "Le nom ne peut être vide.";
		}
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE home_team SET Name = ?, CategoryId = ? WHERE Id = ?", 
                        array("sii", 
                              $this->Name, 
							  $this->CategoryId,                       
							  $this->Id));
	}
	
	public function addNew($mySql)
	{
	    $mySql->prepare("INSERT INTO home_team (Name, CategoryId) VALUES (?, ?)", 
                        array("si",
                              $this->Name, 
                              $this->CategoryId));                                                                                         
	}
} 
?>