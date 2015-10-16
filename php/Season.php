<?php

class Season extends BaseClass
{
    public $Year;
    public $Name;
    public $IsCurrent;
	    
    function __construct()
    {
		
	}
    
    public function initProperty($year, $name, $isCurrent)
    {   
        $this->setProperty($year, $name, $isCurrent);         
    }
    
    public function initDB($year, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM season WHERE year = " . $year);
        $row = $result->fetch_object("Season");
        
        $this->setProperty($row->Year, $row->Name, $row->IsCurrent);        
    }
    
    private function setProperty($year, $name, $isCurrent)
    {
        $this->Year = $year;
        $this->Name = $name;
        $this->IsCurrent = $isCurrent;
		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("year" => "", 
						            "name" => "",
							        "isCurrent" => "");
	}
    
    public function getIsCurrent()
    {
        if ($this->IsCurrent == 1)
        {
            return "Oui";
        }
        else
        {
            return "Non";
        }
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
            if ($mySql->getCount("SELECT * FROM season WHERE year = " . $this->Year) > 0)
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