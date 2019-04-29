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

    protected function setUp()
    {
        date_default_timezone_set('Europe/Paris');
        @unlink(__DIR__.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'jwt.txt');
        @rmdir(__DIR__.DIRECTORY_SEPARATOR.'cache');
        $this->api = new Catalizr\Api();
        $this->api->config->privateKey =  getenv("TEST_PRIVATE_KEY");
        $this->api->config->publicKey = getenv("TEST_PUBLIC_KEY");
        $this->api->config->url = getenv("TEST_URL");
        $this->api->config->folderCache = __DIR__.DIRECTORY_SEPARATOR.'cache';
    }

    /**
     * @param $paginationObject
     * @return void
     */
    protected function assertPagination($paginationObject)
    {
        $this->assertInstanceOf(stdClass::class, $paginationObject);
        $this->assertObjectHasAttribute('items', $paginationObject);
        $this->assertObjectHasAttribute('page', $paginationObject);
        $this->assertObjectHasAttribute('per_page', $paginationObject);
        $this->assertObjectHasAttribute('total_items', $paginationObject);
    }

    /**
     * @param $paginationObject
     * @return void
     */
    protected function assertSortedPagination($paginationObject)
    {
        $this->assertPagination($paginationObject);
        $this->assertObjectHasAttribute('order_by', $paginationObject);
        $this->assertObjectHasAttribute('sort', $paginationObject);
    }
}
