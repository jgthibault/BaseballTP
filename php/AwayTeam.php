<?php

class AwayTeam extends BaseClass
{
    public $Name;
    public $CategoryId;
    public $Id;
    public $City;
            
    function __construct()
    {
		
	}
    
    public function getCategoryDesc($mysql)
    {
        $result = $mysql->execute("SELECT * FROM category WHERE Id = " . $this->CategoryId);
        $row = $result->fetch_object("Category");
        
        return $row->Description;
    }
    
    public function initProperty($id, $name, $categoryId, $city)
    {   
        $this->setProperty($id, $name, $categoryId, $city);         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM away_team WHERE id = " . $id);
        $row = $result->fetch_object("AwayTeam");
        
        $this->setProperty($row->Id, $row->Name, $row->CategoryId, $row->City);        
    }
    
    private function setProperty($id, $name, $categoryId, $city)
    {
        $this->Name = $name;
        $this->CategoryId = $categoryId;
        $this->Id = $id;
        $this->City = $city;
        		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("name" => "",
                                    "city" => "");
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
        
        if (strlen($this->City) > 75)
		{
			$this->m_valueState["city"] = "La ville ne peut dépasser 75 caractères.";
		}
		else if (strlen($this->City) == 0)
		{
			$this->m_valueState["city"] = "La ville ne peut être vide.";
		}
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE away_team SET Name = ?, CategoryId = ?, City = ? WHERE Id = ?", 
                        array("sisi", 
                              $this->Name, 
							  $this->CategoryId,
                              $this->City,                       
							  $this->Id));
	}
	
	public function addNew($mySql)
	{
	    $mySql->prepare("INSERT INTO away_team (Name, CategoryId, City) VALUES (?, ?, ?)", 
                        array("sis",
                              $this->Name, 
                              $this->CategoryId,
                              $this->City));                                                                                         
	}
} 
?>