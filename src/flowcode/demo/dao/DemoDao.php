<?php

namespace flowcode\demo\dao;

use flowcode\demo\domain\Demo;
use flowcode\wing\mvc\Dao;

/**
 * Description of DemoDao
 *
 * @author juanma
 */
class DemoDao extends Dao {

    function __construct() {
        parent::__construct();
    }

    public function save(Demo $demo) {
        if (is_null($demo->getId())) {
            $query = "INSERT INTO `demo` (`name`) ";
            $query .= "VALUES ('" . $demo->getName() . "')";
        }
        $id = $this->executeInsert($query);
        return $id;
    }

    public function findAll() {
        $query = "SELECT * FROM demo ";
        return $this->executeQuery($query);
    }

    public function getInstanceFormArray(
    $raw) {
        $instance = new Demo();
        $instance->setId($raw['id']);
        $instance->setName($raw['name']);
        return $instance;
    }

}

?>
