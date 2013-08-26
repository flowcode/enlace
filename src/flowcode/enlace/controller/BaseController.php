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
     * Roles disponibles en la aplicacion
     *  por defecto estan los siguientes roles:
     *  -admin
     *  -user
     * @var type 
     */
    public $roles = array();

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
     * Add a role to the available roles.
     * @param string $role
     */
    public function addAllowedRole($role) {
        $this->roles[] = $role;
    }

    /**
     * Check if a the role is in the controller available accesing roles.
     * @param type $role
     * @return boolean
     */
    public function canAccess($role) {
        $can = false;
        foreach ($this->roles as $activeRole) {
            if ($activeRole == $role) {
                $can = true;
                break;
            }
        }
        return $can;
    }

    /**
     * Retorna la representacion json del objecto recibido por parametro.
     * @param type $object
     * @return json json. 
     */
    public function toJson($object) {
        $array = $this->toArray($object);
        return str_replace('\\u0000', "", json_encode($array));
    }

    /**
     * Convierte un objeto a notacion json.
     * @param type $obj
     * @return type 
     */
    private function toArray($obj) {
        $arr = array();

        if (is_array($obj)) {
            foreach ($obj as $value) {
                $arr[] = $this->toArray($value);
            }
        }
        if (is_object($obj)) {
            $ardef = array();
            $arObj = (array) $obj;
            foreach ($arObj as $key => $value) {
                $attribute = str_replace(get_class($obj), "", $key);
                if (is_object($value) || is_array($value)) {
                    $value = $this->toArray($value);
                }
                $arr[$attribute] = $value;
            }
        }
        return $arr;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function setRoles($roles) {
        $this->roles = $roles;
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
