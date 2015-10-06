<?php

class Season 
{
    public $Year;
    public $Name;
    public $IsCurrent;
    
    function __construct()
    {}
    
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
    
    public function hasError()
    {
        
    }
} 
?>