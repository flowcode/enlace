<?php

namespace flowcode\enlace\view;

use flowcode\enlace\Enlace;
use Goutte\Client;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-05-11 at 16:53:02.
 */
class JsonViewTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var JsonView
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
       Enlace::set("view", array(
            "path" => __DIR__ . "/aux"
        ));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers flowcode\enlace\view\JsonView::render
     * @todo   Implement testRender().
     */
    public function testRender() {
//        $this->expectOutputString('test');
//        $viewData["data"] = "test";
//        $this->object = new JsonView($viewData);
//        $this->object->render();
    }

}
