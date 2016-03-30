<?php

class Practice extends BaseClass
{
    public $SeasonId = 0;
    public $Season;
    
    public $TeamId = 0;
    public $Team;
    
    public $Date;
    public $Stade;
    public $Id;
    
    function __construct()
    {
		
	}
    
    public function initProperty($id, $seasonId, $teamId, $date, $stade, $mysql)
    {   
        $this->setProperty($id, $seasonId, $teamId, $date, $stade);
        $this->loadObject($mysql);         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM practice WHERE id = " . $id);
        $row = $result->fetch_object("Practice");
        
        $this->setProperty($row->Id, 
                           $row->SeasonId, 
                           $row->TeamId, 
                           $row->Date, 
                           $row->Stade);
        $this->loadObject($mysql);        
    }
    
    private function loadObject($mysql)
    {
        //season
        if ($this->SeasonId <> 0)
        {
            $result = $mysql->execute("SELECT * FROM season WHERE year = " . $this->SeasonId);
            $this->Season = $result->fetch_object("Season");
        }
        
        //team
        if ($this->TeamId <> 0)
        {
            $result = $mysql->execute("SELECT * FROM home_team WHERE Id = " . $this->TeamId);
            $this->Team = $result->fetch_object("HomeTeam");
        }
    }
    
    private function setProperty($id, $seasonId, $teamId, $date, $stade)
    {
        $this->SeasonId = $seasonId;
        $this->Id = $id;
        $this->TeamId = $teamId;
        $this->Date = $date;
        $this->Stade = $stade;
        		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("seasonId" => "",
                                    "teamId" => "", 
                                    "date" => "",
                                    "stade" => "",);
	}
    
    public function validate($mySql)
    {
		$this->initValueState();
        	
		if ($this->SeasonId == 0)
		{
			$this->m_valueState["seasonId"] = "La saison est obligatoire.";
		}
        
        if ($this->TeamId == 0)
		{
			$this->m_valueState["teamId"] = "L'équipe pistoloise est obligatoire.";
		}
        
        if (strlen($this->Stade) > 45)
        {
            $this->m_valueState["stade"] = "Le stade ne peut déapasser 45 caractères.";
        }
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE practice SET SeasonId = ?, 
                                             TeamId = ?, 
                                             Date = ?, 
                                             Stade = ?, 
                                         WHERE Id = ?", 
                        array("iiisi", 
                              $this->SeasonId, 
							  $this->TeamId,
                              $this->Date,
                              $this->Stade,
							  $this->Id));
	}
	
	public function addNew($mySql)
	{

	    $mySql->prepare("INSERT INTO practice (SeasonId, 
                                               TeamId, 
                                               Date, 
                                               Stade) VALUES (?, ?, ?, ?)", 
                        array("iiis",
                              $this->SeasonId, 
							  $this->TeamId,
                              $this->Date,
                              $this->Stade));                                                                                         
	}
} 
?>