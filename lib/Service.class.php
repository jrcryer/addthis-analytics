<?php
/**
 * Responsible communicating with AddThis Analytics API
 *
 * @author James Cryer(j.r.cryer@gmail.com)
 */
class Service {

    /**
     * @var Request
     */
    protected $oRequest;

    /**
     * @var Cache
     */
    protected $oCache;

    /**
     * Constructor, requires request object and cache store
     * 
     * @param Request $oRequest
     * @param Cache $oCache
     */
    public function __construct(Request $oRequest, Cache $oCache) {
        $this->setRequest($oRequest);
        $this->setCache($oCache);
    }

    /**
     * Returns content for the current request
     *
     * @return string
     */
    public function getData() {
        $oRequest = $this->getRequest();
        $request  = $oRequest->getRequest();
        
        if($this->hasCachedRequest($request)) {
            return $this->getCachedRequest($request);
        }
        return $this->sendRequest($request);
    }

    /**
     * Send request to AddThis Analytics API.
     *
     * @param string $request
     * @return string
     */
    public function sendRequest($request) {
        $response = @file_get_contents($request);
        $this->getCache()->putContent($request, $response);
        return json_decode($response);
    }

    /**
     * Checks whether the request is currently cached in the cache store.
     * 
     * @param string $request
     * @return bool
     */
    public function hasCachedRequest($request) {
        return $this->getCache()->isCached($request);
    }

    /**
     * Returns content from cache store
     *
     * @return string
     */
    public function getCachedRequest($request) {
        return json_decode($this->getCache()->getContent($request));
    }

    /**
     * Return current cache store
     * 
     * @return Cache
     */
    public function getCache() {
        return $this->oCache;
    }

    /**
     * Sets the current cache store
     * 
     * @param Cache $oCache
     */
    public function setCache(Cache $oCache) {
        $this->oCache = $oCache;
    }

    /**
     * Returns the current request object
     * 
     * @return Request
     */
    public function getRequest() {
        return $this->oRequest;
    }

    /**
     * Set the current request object
     * 
     * @param Request $oRequest
     */
    public function setRequest(Request $oRequest) {
        $this->oRequest = $oRequest;
    }
}