<?php

class QueryParameterTest extends PHPUnit_Framework_TestCase {

    protected $oParameter;

    public function setUp() {
        $this->oParameter = new QueryParameter('services', 'email,twitter');
    }

    public function tearDown() {
        $this->oParameter = null;
    }

    public function testConstruction() {
        $this->assertTrue(is_a($this->oParameter, 'QueryParameter'));
        $this->assertEquals('services=email,twitter', $this->oParameter->getParameter());
    }

    public function testCanSetParameterAfterConstruct() {
        $this->oParameter->setParameter('domain', 'my.domain.com');
        $this->assertEquals('domain=my.domain.com', $this->oParameter->getParameter());
    }

    public function testUrlParameterValueIsEncoded() {
        $this->oParameter = new QueryParameter('url', 'http://www.mysite.com');
        $this->assertEquals('url=http%3A%2F%2Fwww.mysite.com', $this->oParameter->getParameter());
    }
    
    public function testToStringReturnsKeyValuePair() {
        $this->assertEquals('services=email,twitter', $this->oParameter->__toString());
    }
}