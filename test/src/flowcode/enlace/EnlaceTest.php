<?php

namespace flowcode\enlace;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-08-26 at 20:52:34.
 */
class EnlaceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Enlace
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Enlace();
        $this->object->setMode(Enlace::$MODE_TESTING);
        $this->object->set("src", array(
            "src" => __DIR__ . "/../src",
            "log" => __DIR__ . "/../log"
        ));
        $this->object->set("scanneableControllers", array("enlace" => __DIR__ . "/../src"));
        $this->object->set("defaultController", "\\flowcode\\enlace\\controller\\DefaultController");
        $this->object->set("defaultMethod", "defaultMethod");
        $this->object->set("errorMethod", "errorMethod");
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers flowcode\enlace\Enlace::handleRequest
     * 
     */
    public function testHandleRequest_defaultControllerDefaultMethod() {
        $requestedUrl = "/home";
        $this->object->handleRequest($requestedUrl);
        $this->expectOutputString('Default controller, default method. We strongly recommend to setup your own default controller.');
    }

    /**
     * @covers flowcode\enlace\Enlace::handleRequest
     * 
     */
    public function testHandleRequest_defaultControllerDefaultMethod_testOk() {
        $requestedUrl = "/home";
        $this->object->handleRequest($requestedUrl);
        $this->expectOutputString('Default controller, default method. We strongly recommend to setup your own default controller.');
    }

    public function testHandleRequest_manageParameters_ok() {
        $requestedUrl = "/home?id=1";
        $this->object->handleRequest($requestedUrl);
        $this->expectOutputString('Default controller, default method. We strongly recommend to setup your own default controller.');
    }

    /**
     * @covers flowcode\enlace\Enlace::shutdown
     * @todo   Implement testShutdown().
     */
    public function testShutdown() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getDirPath
     * @todo   Implement testGetDirPath().
     */
    public function testGetDirPath() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getScanneableControllers
     * @todo   Implement testGetScanneableControllers().
     */
    public function testGetScanneableControllers() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setScanneableControllers
     * @todo   Implement testSetScanneableControllers().
     */
    public function testSetScanneableControllers() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getDefaultController
     * @todo   Implement testGetDefaultController().
     */
    public function testGetDefaultController() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getDefaultMethod
     * @todo   Implement testGetDefaultMethod().
     */
    public function testGetDefaultMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getDirs
     * @todo   Implement testGetDirs().
     */
    public function testGetDirs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getLogDir
     * @todo   Implement testGetLogDir().
     */
    public function testGetLogDir() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setDirs
     * @todo   Implement testSetDirs().
     */
    public function testSetDirs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getLoginController
     * @todo   Implement testGetLoginController().
     */
    public function testGetLoginController() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setLoginController
     * @todo   Implement testSetLoginController().
     */
    public function testSetLoginController() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getLoginMethod
     * @todo   Implement testGetLoginMethod().
     */
    public function testGetLoginMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setLoginMethod
     * @todo   Implement testSetLoginMethod().
     */
    public function testSetLoginMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getRestrictedMethod
     * @todo   Implement testGetRestrictedMethod().
     */
    public function testGetRestrictedMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setRestrictedMethod
     * @todo   Implement testSetRestrictedMethod().
     */
    public function testSetRestrictedMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getErrorMethod
     * @todo   Implement testGetErrorMethod().
     */
    public function testGetErrorMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setErrorMethod
     * @todo   Implement testSetErrorMethod().
     */
    public function testSetErrorMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getConfigurationFiles
     * @todo   Implement testGetConfigurationFiles().
     */
    public function testGetConfigurationFiles() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setConfigurationFiles
     * @todo   Implement testSetConfigurationFiles().
     */
    public function testSetConfigurationFiles() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setDefaultController
     * @todo   Implement testSetDefaultController().
     */
    public function testSetDefaultController() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setDefaultMethod
     * @todo   Implement testSetDefaultMethod().
     */
    public function testSetDefaultMethod() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::setMode
     * @todo   Implement testSetMode().
     */
    public function testSetMode() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers flowcode\enlace\Enlace::getMode
     * @todo   Implement testGetMode().
     */
    public function testGetMode() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
