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
        @unlink(__DIR__.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'jwt.txt');
        @rmdir(__DIR__.DIRECTORY_SEPARATOR.'cache');
        $this->api = new Catalizr\Api();
        $this->api->config->privateKey = 'test';
        $this->api->config->publicKey = 'test';
        $this->api->config->url = 'https://preprod.api.catalizr.io/v1';
        $this->api->config->folderCache = __DIR__.DIRECTORY_SEPARATOR.'cache';
    }
}
