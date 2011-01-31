<?php
/**
 * Responsible interacting with file cache store
 *
 * @author James Cryer(j.r.cryer@gmail.com)
 */
class FileCache implements Cache {

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * Constructor, accepts cache directory
     * 
     * @param string $dir
     */
    public function __construct($dir = null) {
        if($dir === null) {
            $dir = sprintf('%s/../cache', dirname(__FILE__));
        }
        $this->cacheDir = realpath($dir);
    }

    /**
     * Checks whether there is a cached response for a given request within
     * the past day.
     *
     * Returns true if there is a cache file, false otherwise.
     * 
     * @param string $request
     * @return bool
     */
    public function isCached($request) {
        $cacheFile = $this->getCacheFilename($request);
        
        if(is_file($cacheFile) && filemtime($cacheFile) > strtotime('-1 day')) {
            return true;
        }
        return false;
    }

    /**
     * Returns cached content for a given request
     * 
     * @param string $request
     * @return string
     */
    public function getContent($request) {
        $cacheFile = $this->getCacheFilename($request);
        $content   = file_get_contents($cacheFile);
        return $content;
    }

    /**
     * Writes the content for a given request to cache store
     * 
     * @param string $request
     * @param string $content
     */
    public function putContent($request, $content) {
        $cacheFile = $this->getCacheFilename($request);
        file_put_contents($cacheFile, $content);
    }

    /**
     * Returns the cache name for a given request
     *
     * @param string $request
     * @return string
     */
    protected function getCacheFilename($request) {
        $key       = $this->generateCacheKeyFromRequest($request);
        return sprintf('%s/%s.cache', $this->cacheDir, $key);
    }

    /**
     * Returns the cache key for a given request
     * 
     * @param string $request
     * @return string
     */
    protected function generateCacheKeyFromRequest($request) {
        return md5($request);
    }
}