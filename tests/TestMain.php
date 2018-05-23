<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of investorTest
 *
 * @author codati
 */
class TestMain extends \PHPUnit\Framework\TestCase{
    /**
     *
     * @var \Catalizr\Api
     */
    protected $api;
    
    protected function setUp() {
        date_default_timezone_set('Europe/Paris');
        @unlink(__DIR__.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'jwt.txt');
        @rmdir(__DIR__.DIRECTORY_SEPARATOR.'cache');
        $this->api = new Catalizr\Api();
        $this->api->config->privateKey = 'privateKey';
        $this->api->config->publicKey = 'aUniquePublicKey';
        $this->api->config->url = 'https://dev.api.catalizr.io';
        $this->api->config->folderCache = __DIR__.DIRECTORY_SEPARATOR.'cache';
    }
}
