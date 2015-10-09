<?php

class Season extends BaseClass
{
    public $Year;
    public $Name;
    public $IsCurrent;
	public $PageMode;
    
    private $m_valueState;
	    
    function __construct()
    {
		$this->IsCurrent = false;
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
        if ($this->IsCurrent)
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
        else if($this::$PageMode == Constants::PAGE_MODE_ADD)
        { 
            if ($mySql->getCount("SELECT * FROM season WHERE season = " . $this->Year) > 0)
            {
                $this->m_valueState["year"] = "L'année doit être unique.";
            }
        }
		
		if (strlen($this->Name) > 15)
		{
			$this->m_valueState["name"] = "Le nom ne peut dépasser 15 caractères.";
		}
		else if (strlen($this->Name) == 0)
		{
			$this->m_valueState["name"] = "Le nom ne peut être vide.";
		}
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE season SET name = ?, iscurrent = ? WHERE year = ?", "iii", array($this->Name, 
																								 $this->IsCurrent,
																								 $this->Year));
	}
	
	public function addNew($mySql)
	{
		$mySql->prepare("INSERT INTO season (Year, Name, IsCurrent) VALUES (?, ?, ?)", "iii", array($this->Year, 
																									$this->Name, 
																									$this->IsCurrent));
	}
	
	public function getHasError()
	{
		return $this->m_valueState["year"] <> "" or 
			   $this->m_valueState["name"] <> "" or
			   $this->m_valueState["isCurrent"] <> "";
	}
	
	public function attributeHasError($attName)
	{
		return $this->m_valueState[$attName] <> "";
	}
	
	public function getAttributeError($attName)
	{
		return $this->m_valueState[$attName];
	}
} 
?>