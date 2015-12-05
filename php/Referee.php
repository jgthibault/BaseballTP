<?php

class Referee extends BaseClass
{
    public $FirstName;
    public $LastName;
    public $Id;
    
    public function getFullName()
    {
        return $this->FirstName . " " . $this->LastName;
    }
	    
    function __construct()
    {
		
	}
    
    public function initProperty($id, $firstName, $lastName)
    {   
        $this->setProperty($id, $firstName, $lastName);         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM referee WHERE id = " . $id);
        $row = $result->fetch_object("Referee");
        
        $this->setProperty($row->Id, $row->FirstName, $row->LastName);        
    }
    
    private function setProperty($id, $firstName, $lastName)
    {
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
        $this->Id = $id;
		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("firstName" => "", 
						            "lastName" => "");
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
			$this->m_valueState["lastName"] = "Le de famille ne peut être vide.";
		}
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE referee SET FirstName = ?, LastName = ? WHERE Id = ?", array("ssi", 
                                                                                          $this->FirstName, 
																					      $this->LastName,
																						  $this->Id));
	}
	
	public function addNew($mySql)
	{
		$mySql->prepare("INSERT INTO referee (FirstName, LastName) VALUES (?, ?)", array("ss",
                                                                                         $this->FirstName, 
																						 $this->LastName));                                                                                             
	}
} 
?>