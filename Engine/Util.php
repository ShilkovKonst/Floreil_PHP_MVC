<?php

namespace Floreil_PHP_MVC\Engine;

class Util
{
    public function getView($sViewName)
    {
        $this->_get('View', $sViewName);
    }

    public function getModel($sModelName)
    {
        $this->_get('Model', $sModelName);
    }

    /**
     * Cette méthode est utile pour éviter la duplication de code (crée presque la même méthode pour "getView" et "getModel")
     */
    private function _get($sType, $sFileName)
    {
        $sFullPath = ROOT_PATH . $sType . '/' . $sFileName . '.php';
        if (is_file($sFullPath))
            require $sFullPath;
        else
            exit('The "' . $sFullPath . '" file doesn\'t exist');
    }

    /**
     * Défini les variables pour les template views.
     */
    public function __set($sKey, $mVal)
    {
        $this->$sKey = $mVal;
    }
}