<?php

require '../bin/Authentication.class.php';

class AuthenticationTest extends PHPUnit_Framework_TestCase {

    protected $oAuth;
    
    public function setUp() {
        $this->oAuth = new Authentication('myuser', 'mypass');
    }

    public function tearDown() {
        $this->oAuth = null;
    }

    public function testConstruction() {
        $this->assertTrue(is_a($this->oAuth, 'Authentication'));
        $this->assertEquals('myuser', $this->oAuth->getUsername());
        $this->assertEquals('mypass', $this->oAuth->getPassword());
    }

    public function testCanChangeUsername() {
        $this->oAuth->setUsername('diff-account');
        $this->assertEquals('diff-account', $this->oAuth->getUsername());
    }

    public function testCanChangePassword() {
        $this->oAuth->setUsername('diff-pass');
        $this->assertEquals('diff-pass', $this->oAuth->getUsername());
    }

    public function testCanGenerateAuthenticationParams() {
        $this->assertEquals('username=myuser&password=mypass', $this->oAuth->__toString());
    }
}