<?php

class Marker extends BaseClass
{
    public $FirstName;
    public $LastName;
    public $Id;
    public $Birth;
    
    public function getFullName()
    {
        return $this->FirstName . " " . $this->LastName;
    }
	    
    function __construct()
    {
		
	}
    
    public function initProperty($id, $firstName, $lastName, $birth)
    {   
        $this->setProperty($id, $firstName, $lastName, strtotime($birth));         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM marker WHERE id = " . $id);
        $row = $result->fetch_object("Marker");
        
        $this->setProperty($row->Id, $row->FirstName, $row->LastName, $row->Birth);        
    }
    
    private function setProperty($id, $firstName, $lastName, $birth)
    {
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
        $this->Id = $id;
        $this->Birth = $birth;
		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("firstName" => "", 
						            "lastName" => "",
                                    "birth" => "");
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
        
        if ($this->Birth != 0 && !checkdate(intval(date("m", $this->Birth)),
                                            intval(date("d", $this->Birth)),
                                            intval(date("Y", $this->Birth))))
        {
            $this->m_valueState["lastName"] = "La date de naissance n'est pas valide.";
        }
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE marker SET FirstName = ?, LastName = ?, Birth = ? WHERE Id = ?", 
                        array("ssii", 
                              $this->FirstName, 
							  $this->LastName,
                              $this->Birth,                              
							  $this->Id));
	}
	
	public function addNew($mySql)
	{
		$mySql->prepare("INSERT INTO referee (FirstName, LastName, Birth) VALUES (?, ?, ?)", 
                        array("ssi",
                              $this->FirstName, 
                              $this->LastName,
                              $this->Birth));                                                                                         
	}
} 
?>