<?php

class Referee extends BaseClass
{
    public $Id;
    public $FirstName;
    public $LastName;
	
	    
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
        $this->Id = $id;
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("id" => "", 
						            "firstName" => "",
							        "lastName" => "");
	}
       
    public function validate($mySql)
    {
		$this->initValueState();
		
        if (!is_numeric($this->Year))
		{
			$this->m_valueState["year"] = "L'année doit être un nombre valide.";
		}
        else if($this->PageMode == Constants::PAGE_MODE_ADD)
        { 
            if ($mySql->getCount("SELECT * FROM season WHERE season = " . $this->Year) > 0)
            {
                $this->m_valueState["year"] = "L'année doit être unique.";
            }
        }
		
		if (strlen($this->Name) > 50)
		{
			$this->m_valueState["name"] = "Le nom ne peut dépasser 50 caractères.";
		}
		else if (strlen($this->Name) == 0)
		{
			$this->m_valueState["name"] = "Le nom ne peut être vide.";
		}
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE season SET Name = ?, IsCurrent = ? WHERE Year = ?", array("sii", 
                                                                                          $this->Name, 
																					      ($this->IsCurrent) ? 1 : 0,
																						  $this->Year));
                                                                                          
        //On désactive tous les autres saisons courantes si la saison es courante
        if ($this->IsCurrent == 1)
        {
            $mySql->prepare("UPDATE season SET IsCurrent = 0 WHERE Year <> ?", array("i", 
                                                                                     $this->Year));
        }
        
	}
	
	public function addNew($mySql)
	{
		$mySql->prepare("INSERT INTO season (Year, Name, IsCurrent) VALUES (?, ?, ?)", array("isi",
                                                                                             $this->Year, 
																							 $this->Name, 
																							 $this->IsCurrent));
                                                                                             
        //On désactive tous les autres saisons courantes si la saison es courante
        if ($this->IsCurrent == 1)
        {
            $mySql->prepare("UPDATE season SET IsCurrent = 0 WHERE Year <> ?", array("i", 
                                                                                     $this->Year));
        }                                                                                             
	}
} 
?>