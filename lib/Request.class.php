<?php
/**
 * Responsible for constructing the request for AddThis Analytics API
 *
 * @author James Cryer(j.r.cryer@gmail.com)
 */
class Request {
    
    const API_URL  = 'http://api.addthis.com/analytics/1.0/pub/';

    const RESPONSE = 'json';

    /**
     * @var Authentication
     */
    protected $oAuth;

    /**
     * @var Metric
     */
    protected $oMetric;

    /**
     * @var Dimension
     */
    protected $oDimension;

    /**
     * @var array of QueryParameters
     */
    protected $aQuery;

    /**
     * Constructor
     * 
     * @param Authentication $oAuth
     * @param Metric $oMetric
     * @param Dimension $oDimension
     * @param array $aQuery
     */
    public function  __construct(
        Authentication $oAuth,
        Metric $oMetric,
        $oDimension = null,
        $aQuery = array()
    ) {
        $this->setAuthentication($oAuth);
        $this->setMetric($oMetric);
        $this->setDimension($oDimension);
        $this->setQuery($aQuery);
    }

    /**
     * Generates the request URL based on current properties
     *
     * @return string
     */
    public function getRequest() {
        $request = $this->generateRequest(
            $this->getServicePath(),
            $this->getServiceQuery()
        );
        return $request;
    }

    /**
     * Returns the API URL path
     * 
     * @return string
     */
    protected function getServicePath() {
        return sprintf(
            '%s%s%s.%s?',
            self::API_URL, $this->getMetric(), strlen($this->getDimension()) > 0 ? "/{$this->getDimension()}" : "", self::RESPONSE
        );
    }

    /**
     * Returns the API URL query string
     * 
     * @return string
     */
    protected function getServiceQuery() {
        $aQuery = $this->getQuery();

        return sprintf(
            '%s%s',
            $this->getAuthentication(),
            empty($aQuery) ? '' : '&'.join('&', $aQuery)
        );
    }

    /**
     * Returns the full request for the API
     * 
     * @param string $path
     * @param string $query
     * @return string
     */
    protected function generateRequest($path, $query) {
        return sprintf('%s%s', $path, $query);
    }

    /**
     * Returns the Authentication object
     * 
     * @return Authentication
     */
    public function getAuthentication() {
        return $this->oAuth;
    }

    /**
     * Set the Authentication
     * 
     * @param Authentication $oAuth
     */
    public function setAuthentication(Authentication $oAuth) {
        $this->oAuth = $oAuth;
    }

    /**
     * Returns the metric
     * 
     * @return Metrics
     */
    public function getMetric() {
        return $this->oMetric;
    }

    /**
     * Sets the metric
     * 
     * @param Metric $oMetric
     */
    public function setMetric(Metric $oMetric) {
        $this->oMetric = $oMetric;
    }

    /**
     * Returns the dimension
     * 
     * @return Dimension
     */
    public function getDimension() {
        return $this->oDimension;
    }

    /**
     * Sets the dimension for the request
     * 
     * @param Dimension $oDimension
     */
    public function setDimension($oDimension) {
        $this->oDimension = $oDimension;
    }

    /**
     * Returns the request parameters
     * 
     * @return array
     */
    public function getQuery() {
        return $this->aQuery;
    }

    /**
     * Sets the request parameters
     * 
     * @param array $aQuery
     */
    public function setQuery($aQuery) {
        $this->aQuery = $aQuery;
    }
 }