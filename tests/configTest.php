<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'TestMain.php';

/**
 * Description of investorTest
 *
 * @author codati
 * @group banck
 */
class configTest extends \PHPUnit\Framework\TestCase {
    
    public function testConfig() {
        $config= array(
            'privateKey' => 'test',
            'publicKey' => 'test',
            'url' => 'http://test.com',
            'folderCache'=> '/my/super/test'
            );
        $api = new \Catalizr\Api($config);
        $this->assertSame($api->config->privateKey, 'test');
        $this->assertSame($api->config->publicKey, 'test');
        $this->assertSame($api->config->url, 'http://test.com');
        $this->assertSame($api->config->folderCache, '/my/super/test');
    }
}
