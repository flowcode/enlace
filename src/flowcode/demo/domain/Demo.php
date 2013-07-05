<?php

namespace flowcode\demo\domain;

use flowcode\wing\mvc\Entity;

/**
 * Description of Demo
 *
 * @author juanma
 */
class Demo extends Entity {

    private $name;

    function __construct() {
        parent::__construct();
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

}

?>
