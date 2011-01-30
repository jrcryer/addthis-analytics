<?php
require '../bin/Cache.interface.php';
require '../bin/FileCache.class.php';

class FileCacheTest extends PHPUnit_Framework_TestCase {
    
    protected $oCache;

    public function setUp() {
        $this->emptyCacheStore();
        $this->oCache = new FileCache($this->getCacheDir());
    }

    public function tearDown() {
        $this->oCache = null;
        $this->emptyCacheStore();
    }

    public function testConstruction() {
        $this->assertTrue(is_a($this->oCache, 'FileCache'));
        $this->assertTrue(is_a($this->oCache, 'Cache'));
    }
    
    public function testPuttingContentToCache() {
        $request  = 'test-cache';
        $filename = sprintf(
            '%s%s.cache',
            $this->getCacheDir(),
            md5($request)
        );
        
        $this->oCache->putContent($request, 'content');
        $this->assertTrue(is_file($filename));
        $this->assertEquals('content', file_get_contents($filename));
    }

    public function testGetContentFromCache() {
        $request  = 'test-cache';
        $filename = sprintf(
            '%s%s.cache',
            $this->getCacheDir(),
            md5($request)
        );

        $this->oCache->putContent($request, 'content');
        $this->assertTrue(is_file($filename));
        $this->assertEquals('content', $this->oCache->getContent($request));
    }

    public function testShouldHaveCacheForRecentlyAddedFile() {
        $request  = 'test-cache';
        $filename = sprintf(
            '%s%s.cache',
            $this->getCacheDir(),
            md5($request)
        );
        $newRequest = 'test-new-request';

        $this->oCache->putContent($request, 'content');
        $this->assertTrue(is_file($filename));
        $this->assertTrue($this->oCache->isCached($request));
        $this->assertFalse($this->oCache->isCached($newRequest));
    }

    protected function emptyCacheStore() {
        $dir   = $this->getCacheDir();
        $aFile = scandir($dir);
        
        array_walk($aFile, function($filename) use($dir) {
            if(preg_match('/\.cache$/', $filename)) {
                unlink(realpath($dir.$filename));
            }
        });
    }

    final function getCacheDir() {
        return dirname(__FILE__).'/data/cache/';
    }
}