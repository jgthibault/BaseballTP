<?php

class Coach extends BaseClass
{
    public $FirstName;
    public $LastName;
    public $Id;
    public $TeamId;
    
    public function getFullName()
    {
        return $this->FirstName . " " . $this->LastName;
    }
	
	public function getTeamName($mysql)
    {
        $result = $mysql->execute("SELECT * FROM home_team WHERE Id = " . $this->TeamId);
        $row = $result->fetch_object("HomeTeam");
        
        return $row->Name;
    }
	    
    function __construct()
    {
		
	}
    
    public function initProperty($id, $firstName, $lastName, $teamId)
    {   
        $this->setProperty($id, $firstName, $lastName, $teamId);         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM coach WHERE id = " . $id);
        $row = $result->fetch_object("Coach");
        
        $this->setProperty($row->Id, $row->FirstName, $row->LastName, $row->$TeamId);        
    }
    
    private function setProperty($id, $firstName, $lastName, $teamId)
    {
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
        $this->Id = $id;
        $this->TeamId = $teamId;
		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("firstName" => "", 
						            "lastName" => "",
                                    "teamId" => "",);
	}
    
    
    public function validate($mySql)
    {
		$this->initValueState();
        		

		if (strlen($this->FirstName) > 45)
		{
			$this->m_valueState["firstName"] = "Le prénom ne peut dépasser 45 caractères.";
		}
		else if (strlen($this->FirstName) == 0)
		{
			$this->m_valueState["firstName"] = "Le prénom ne peut être vide.";
		}
        
        if (strlen($this->LastName) > 45)
		{
			$this->m_valueState["lastName"] = "Le nom de famille ne peut dépasser 45 caractères.";
		}
		else if (strlen($this->LastName) == 0)
		{
			$this->m_valueState["lastName"] = "Le nom de famille ne peut être vide.";
		}
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE coach SET FirstName = ?, LastName = ?, TeamId = ? WHERE Id = ?", 
                        array("ssii", 
                              $this->FirstName, 
							  $this->LastName,
                              $this->TeamId,
							  $this->Id));
	}
	
	public function addNew($mySql)
	{

	    $mySql->prepare("INSERT INTO coach (FirstName, LastName, TeamId) VALUES (?, ?, ?)", 
                        array("ssi",
                              $this->FirstName, 
                              $this->LastName,
                              $this->TeamId));
	}
} 
?>