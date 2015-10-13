<?php

class BaseClass
{
	public $PropertyState;
    public $PageMode;
    
    protected $m_valueState;
    
    public function attributeHasError($attName)
	{
		return $this->m_valueState[$attName] <> "";
	}
	
	public function getAttributeError($attName)
	{
		return $this->m_valueState[$attName];
	}
    
    public function getHasError()
	{
	    foreach ($this->m_valueState as $key)
        {
            if ($key <> "")
            {
                return true;
            } 
        }
     
        return false;
	}
}
?>