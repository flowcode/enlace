<?php

namespace flowcode\demo\service;

use flowcode\demo\dao\DemoDao;
use flowcode\demo\domain\Demo;

/**
 * Description of DemoService
 *
 * @author juanma
 */
class DemoService {

    private $demoDao;

    function __construct(DemoDao $demoDao = NULL) {
        if (!is_null($demoDao)) {
            $this->demoDao = $demoDao;
        }
    }

    public function findAll() {
        return $this->getDemoDao()->findAll();
    }

    public function save(Demo $demo) {
        return $this->getDemoDao()->save($demo);
    }

    public function getDemoDao() {
        if (is_null($this->demoDao))
            $this->demoDao = new DemoDao();
        return $this->demoDao;
    }

    public function setDemoDao($demoDao) {
        $this->demoDao = $demoDao;
    }

}

?>
