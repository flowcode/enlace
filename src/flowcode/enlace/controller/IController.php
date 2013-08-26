<?php

namespace flowcode\enlace\controller;

/**
 * Controller Interface.
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
interface IController {

    /**
     * Return true if the controller is setted to be secured.
     * @return bool secured.
     */
    public function isSecure();

    /**
     * Check if a the role is in the controller available accesing roles.
     * @param type $role
     * @return boolean
     */
    public function canAccess($role);
}

?>
