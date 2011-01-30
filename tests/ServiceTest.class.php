<?php

require_once '../bin/Service.class.php';
require_once '../bin/Request.class.php';
require_once '../bin/Cache.interface.php';
require_once '../bin/FileCache.class.php';

class ServiceTest extends PHPUnit_Framework_TestCase {

    protected $oService;

    public function setUp() {
        $oRequest       = $this->getMock('Request', array(), array(), '', false);
        $oCache         = $this->getMock('FileCache', array('isCached', 'putContent', 'getContent'), array(), '', false);
        
        $this->oService = new Service($oRequest, $oCache);
    }

    public function tearDown() {
        $this->oService = null;
    }

    public function testConstruction() {
        $this->assertTrue(is_a($this->oService, 'Service'));
    }

    public function testSendRequestToService() {
        $request  = realpath(dirname(__FILE__)).'/data/sample-request.json';
        $oRequest = $this->getMock('Request', array('getRequest'), array(), '', false);
        $oRequest->expects($this->once())
                 ->method('getRequest')
                 ->will($this->returnValue($request));
        
        $oCache = $this->getMock('FileCache', array('isCached', 'putContent', 'getContent'), array(), '', false);
        $oCache->expects($this->once())
               ->method('isCached')
               ->with($this->equalTo($request))
               ->will($this->returnValue(false));
        $oCache->expects($this->once())
               ->method('putContent');
        
        $this->oService->setRequest($oRequest);
        $this->oService->setCache($oCache);
        
        $aData = $this->oService->getData();
        $oData = current($aData);

        $this->assertEquals('2009-09-09', $oData->date);
        $this->assertEquals(8521, $oData->shares);
    }

    public function testSendRequestServedByCache() {
        $request  = realpath(dirname(__FILE__)).'/data/sample-request.json';
        $oRequest = $this->getMock('Request', array('getRequest'), array(), '', false);
        $oRequest->expects($this->once())
                 ->method('getRequest')
                 ->will($this->returnValue($request));

        $oCache = $this->getMock('FileCache', array('isCached', 'putContent', 'getContent'), array(), '', false);
        $oCache->expects($this->once())
               ->method('isCached')
               ->with($this->equalTo($request))
               ->will($this->returnValue(true));
        $oCache->expects($this->once())
               ->method('getContent')
               ->will($this->returnValue(file_get_contents($request)));

        $this->oService->setRequest($oRequest);
        $this->oService->setCache($oCache);

        $aData = $this->oService->getData();
        $oData = current($aData);

        $this->assertEquals('2009-09-09', $oData->date);
        $this->assertEquals(8521, $oData->shares);
    }
}