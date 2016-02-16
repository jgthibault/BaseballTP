<?php

class HomeTeam extends BaseClass
{
    public $Name;
    public $CategoryId;
    public $Id;
            
    function __construct()
    {
		
	}
    
    public function getCategoryDesc($mysql)
    {
        $result = $mysql->execute("SELECT * FROM category WHERE Id = " . $this->CategoryId);
        $row = $result->fetch_object("Category");
        
        return $row->Description;
    }
    
    public function initProperty($id, $name, $categoryId)
    {   
        $this->setProperty($id, $name, $categoryId);         
    }
    
    public function initDB($id, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM home_team WHERE id = " . $id);
        $row = $result->fetch_object("HomeTeam");
        
        $this->setProperty($row->Id, $row->Name, $row->CategoryId);        
    }
    
    private function setProperty($id, $name, $categoryId)
    {
        $this->Name = $name;
        $this->CategoryId = $categoryId;
        $this->Id = $id;
        		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("name" => "");
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