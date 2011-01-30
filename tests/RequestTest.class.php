<?php

require '../bin/Request.class.php';
require '../bin/Authentication.class.php';
require '../bin/Metric.class.php';
require '../bin/Dimension.class.php';
require '../bin/QueryParameter.class.php';

class RequestTest extends PHPUnit_Framework_TestCase {

    protected $oRequest;
    
    public function setUp() {
        $this->oRequest = new Request(
            new Authentication('myuser', 'mypass'),
            new Metric('shares'),
            new Dimension('content'),
            array()
        );
    }

    public function tearDown() {
        $this->oRequest = null;
    }
    
    public function testConstruct() {
        $this->assertTrue(is_a($this->oRequest, 'Request'));
    }

    public function testFormatDefaultToJson() {
        $this->assertEquals('json', $this->oRequest->getFormat());
    }

    public function testCanProduceApiUrl() {
        $this->assertEquals(
            'http://api.addthis.com/analytics/1.0/pub/shares/content.json?username=myuser&password=mypass',
            $this->oRequest->getRequest()
        );
    }

    public function testCanAlterMetric() {
        $this->oRequest->setMetric(new Metric('subscriptions'));
        
        $this->assertEquals(
            'http://api.addthis.com/analytics/1.0/pub/subscriptions/content.json?username=myuser&password=mypass',
            $this->oRequest->getRequest()
        );
    }

    public function testCanAlterDimension() {
        $this->oRequest->setDimension(new Dimension('country'));

        $this->assertEquals(
            'http://api.addthis.com/analytics/1.0/pub/shares/country.json?username=myuser&password=mypass',
            $this->oRequest->getRequest()
        );
    }

    public function testDimensionIsOptional() {
        $this->oRequest->setDimension(null);

        $this->assertEquals(
            'http://api.addthis.com/analytics/1.0/pub/shares.json?username=myuser&password=mypass',
            $this->oRequest->getRequest()
        );
    }

    public function testCanChangeAccount() {
        $this->oRequest->setAuthentication(
            new Authentication('anotheruser', 'anotherpass')
        );

        $this->assertEquals(
            'http://api.addthis.com/analytics/1.0/pub/shares/content.json?username=anotheruser&password=anotherpass',
            $this->oRequest->getRequest()
        );
    }

    public function testCanChangeFormat() {
        $this->oRequest->setFormat('csv');
        
        $this->assertEquals(
            'http://api.addthis.com/analytics/1.0/pub/shares/content.csv?username=myuser&password=mypass',
            $this->oRequest->getRequest()
        );
    }

    public function testCanSetRequestParameters() {
        $this->oRequest->setQuery(array(
            new QueryParameter('service', 'email,twitter'),
            new QueryParameter('url', 'http://www.myurl.com')
        ));

        $this->assertEquals(
            'http://api.addthis.com/analytics/1.0/pub/shares/content.json?username=myuser&password=mypass&service=email,twitter&url=http%3A%2F%2Fwww.myurl.com',
            $this->oRequest->getRequest()
        );
    }
}