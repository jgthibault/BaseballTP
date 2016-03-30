<?php

class Content extends BaseClass
{
    public $Id;
    public $Page;
    public $Code;
	
	public $PageName;
        
    function __construct()
    {
		
	}
    
    public function initProperty($id, $page, $code)
    {   
        $this->setProperty($id, $page, $code);         
    }
    
    public function initDB($page, $mysql)
    {
        $result = $mysql->execute("SELECT * FROM content WHERE page = '" . $page . "'");
        $row = $result->fetch_object("Content");
        
        $this->setProperty($row->Id, $row->Page, $row->Code);        
    }
    
    private function setProperty($id, $page, $code)
    {
        $this->Id = $id;
        $this->Page = $page;
        $this->Code = $code;
		
		if ($page == Constants::PAGE_CONTENT_HOME)
		{
			$this->PageName = "Accueil";
		}
		else if ($page == Constants::PAGE_CONTENT_JOIN)
		{
			$this->PageName = "Nous joindre";
		}
		else if ($page == Constants::PAGE_CONTENT_STAFF)
		{
			$this->PageName = "Association";
		}
        		
		$this->initValueState();
    }
	
	private function initValueState()
	{
	    $this->m_valueState = array("id" => "", 
						            "page" => "",
                                    "code" => "",);
	}
    
    
    public function validate($mySql)
    {
		$this->initValueState();
    }
	
	public function update($mySql)
	{
		$mySql->prepare("UPDATE content SET Code = ? WHERE Id = ?", 
                        array("si", 
                              $this->Code, 
							  $this->Id));
	}
} 
?>