<?php

namespace flowcode\enlace\controller;

/**
 * BaseController with base functionality for WingMVC.
 * It's recommended to extend your app controllers from this one.
 *
 * @author juanma
 */
class BaseController implements IController {

    public $isSecure = true;
    protected $module;
    protected $name;

    /**
     * Permissions that are allowed to access to this controller instance.
     * @var type 
     */
    protected $permissions = array();

    public function setIsSecure($isSecure) {
        $this->isSecure = $isSecure;
    }

    /**
     * Force synchronized redirect.
     * @param type $to_url
     */
    public function redirect($to_url) {
        header("Location: $to_url");
    }

    /**
     * Return true if the controller is setted to be secured.
     * @return bool secured.
     */
    public function isSecure() {
        return $this->isSecure;
    }

    /**
     * Add a required permission to access to this controller.
     * @param string $permission
     */
    public function addPermission($permission) {
        $this->permissions[] = $permission;
    }

    /**
     * Test if the user has the required permissions to access.
     * @param type $user
     * @return boolean
     */
    public function canAccess($user) {
        $can = false;
        foreach ($user["roles"] as $userRole) {
            foreach ($userRole["permissions"] as $permission) {
                if (in_array($permission, $this->permissions)) {
                    $can = true;
                    break;
                }
            }
        }
        return $can;
    }

    public function getModule() {
        return $this->module;
    }

    public function setModule($module) {
        $this->module = $module;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

}

?>
