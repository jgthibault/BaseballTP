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
		$ValueState = array("year" => "", 
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
    
    public function validate()
    {
		$this->initValueState();
		
        if (!is_numeric($this->Year))
		{
			$ValueState["year"] = "L'année doit être un nombre valide";
		}
		
		if (strlen
    }
	
	public function hasError()
	{
		return $ValueState["year"] <> "" or 
			   $ValueState["name"] <> "" or
			   $ValueState["isCurrent"] <> "" or;
	}
} 
?>