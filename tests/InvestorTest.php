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
class InvestorTest extends \PHPUnit\Framework\TestCase{
    /**
     *
     * @var \Catalizr\Api
     */
    protected $api;
        /**
     *
     * @var \Catalizr\Entity\Investors
     */
    protected $investor;
    protected function setUp() {
        unlink(__DIR__.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'jwt.txt');
        rmdir(__DIR__.DIRECTORY_SEPARATOR.'cache');
        $this->api = new Catalizr\Api();
        $this->api->config->privateKey = 'test';
        $this->api->config->publicKey = 'test';
        $this->api->config->url = 'https://preprod.api.catalizr.io/v1';
        $this->api->config->folderCache = __DIR__.DIRECTORY_SEPARATOR.'cache';
    }
    public function testCreateErrorApi() {
        
        $investor = new Catalizr\Entity\Investors();
        try{
            $this->api->investors->create($investor);

        } catch (\Catalizr\Lib\HttpException $ex) {
          $this->assertSame(400, $ex->getCode(),'http code');
          $this->assertSame('"name" is required', $ex->getMessage());
        }
        return $investor;
    }
    /**
     * 
     * @depends testCreateErrorApi
     */
    public function testCreate(\Catalizr\Entity\Investors $investor) {
        $investor->name = 'Test';
        $investor->surname = 'PHP';
        $investor->birth_date = '03/08/1990';
        $investor->birth_city = 'Hirson';
        $investor->address = 'Doge B, 4 Avenue des Saules';
        $investor->zip = '59000';
        $investor->city = 'Lille';
        $investor->country= 'France';
        $investor->title= 'Lib';
        $investor->iid= time();
        $this->api->investors->create($investor);
        
        $this->assertInternalType('string', $investor->id);
        $this->assertInternalType('string', $investor->iid);
        return $investor;
    }
    public function testGetError() {
        try {
            $this->api->investors->getById('rrrrrrrrrrrrrrrrrrrrrrrr');

        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"investor_id" must only contain hexadecimal characters', $ex->getMessage());
        }

        try {
            $this->api->investors->getById('edfedfedfedfedfedfedfedf');

        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');
            $this->assertSame('Investor not found', $ex->getMessage());
        }
    }
    /**
     * 
     * @depends testCreate
     */
    public function testGet(\Catalizr\Entity\Investors $investor) {
        // get by id
        $investorGetId = $this->api->investors->getById($investor->id);
        // get by iid
        $investorGetIid = $this->api->investors->getByExternalId($investor->iid);
        $this->assertEquals($investorGetId,$investorGetIid);


        $this->assertSame($investorGetId->name, 'Test');
        $this->assertSame($investorGetId->surname, 'PHP');
        $this->assertSame($investorGetId->birth_date, '1990-03-08T00:00:00.000Z');
        $this->assertSame($investorGetId->birth_city, 'Hirson');
        $this->assertSame($investorGetId->address, 'Doge B, 4 Avenue des Saules');
        $this->assertSame($investorGetId->zip, '59000');
        $this->assertSame($investorGetId->city, 'Lille');
        $this->assertSame($investorGetId->country, 'France');
        $this->assertSame($investorGetId->title, 'Lib');
        $this->assertSame($investorGetId->id, $investor->id);
        $this->assertSame($investorGetId->iid, $investor->iid);
       
        // get all ids
        $ids = $this->api->investors->getAllid();

        $this->assertContainsOnly('string', $ids);

        // get id by iid

        $id = $this->api->investors->getIdByExternalIid($investor->iid);
        
        $this->assertSame($id, $investor->id);
        
        return $investor->id;
    }

    
}
