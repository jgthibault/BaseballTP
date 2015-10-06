<?php
class ErrorHandling
{
    public $ControlId;
    public $ErrorMessage;
    
    public function getHasError()
    {
        return strlen($this->ErrorMessage > 0);
    }
}

?>