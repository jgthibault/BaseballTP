<?php

class Season 
{
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
} 
?>