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
 * @group companies
 */
class C_CompaniesTest extends TestMain {
    /**
     *
     * @var \Catalizr\Entity\Companies
     */
    static $companie;
    
    public function testCreateErrorApi() {
        $company = new \Catalizr\Entity\Companies();
        try{
            
            $this->api->companies->create($company);

        } catch (\Catalizr\Lib\HttpException $ex) {
          $this->assertSame(400, $ex->getCode(),'http code');
          $this->assertSame('"name" is required', $ex->getMessage());
        }
        return $company;
    }

    public function testCreate() {
        $company = new \Catalizr\Entity\Companies();

        $company->name = 'utocat';
        $company->legal_form = 'SAS';
        $company->phone = '0123456789';
        $company->address = 'Doge B, 4 Avenue des Saules';
        $company->zip = '59000';
        $company->city = 'Lille';
        $company->country = 'France';
        $company->in_progress = false;
        $company->siret = 'MySiret';
        $this->api->companies->create($company);
        
        $this->assertInternalType('string', $company->id);
    }
    public function testCreateFull() {
        $company = new \Catalizr\Entity\Companies();

        $company->name = 'utocat';
        $company->legal_form = 'SAS';
        $company->phone = '0123456789';
        $company->address = 'Doge B, 4 Avenue des Saules';
        $company->zip = '59000';
        $company->city = 'Lille';
        $company->country = 'France';
        $company->in_progress = false;
        $company->siret = 'MySiret';
        $company->email= 'suport@utocat.com';
        $company->iid= time();
        $this->api->companies->create($company);
        $this->assertInternalType('string', $company->id);
        $this->assertInternalType('string', $company->iid);
        return $company;
    }
    
    public function testGetError() {
        try {
            $this->api->companies->getById('rrrrrrrrrrrrrrrrrrrrrrrr');

        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"company_id" must only contain hexadecimal characters', $ex->getMessage());
        }

        try {
            $this->api->companies->getById('edfedfedfedfedfedfedfedf');

        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');
            $this->assertSame('Company not found', $ex->getMessage());
        }
    }
     /**
     * 
     * @depends testCreateFull
     */
    public function testGet(\Catalizr\Entity\Companies $company) {
        // get by id
        self::$companie = $this->api->companies->getById($company->id);
        // get by iid
        $companyGetIid = $this->api->companies->getByExternalId($company->iid);
        $this->assertEquals(self::$companie,$companyGetIid);

        $this->assertSame(self::$companie->name, 'utocat');
        $this->assertSame(self::$companie->legal_form, 'SAS');
        $this->assertSame(self::$companie->address, 'Doge B, 4 Avenue des Saules');
        $this->assertSame(self::$companie->zip, '59000');
        $this->assertSame(self::$companie->city, 'Lille');
        $this->assertSame(self::$companie->country, 'France');
        $this->assertSame(self::$companie->in_progress, false);
        $this->assertSame(self::$companie->siret, 'MySiret');
        $this->assertSame(self::$companie->email, 'suport@utocat.com');

        $this->assertInternalType('string',self::$companie->createdAt);
        $this->assertInternalType('string',self::$companie->updatedAt);

        
        $this->assertSame(self::$companie->id, $company->id);
        $this->assertSame(self::$companie->iid, $company->iid);

        // get all ids
        $ids = $this->api->companies->getAllid();

        $this->assertContainsOnly('string', $ids);

        // get id by iid

        $id = $this->api->companies->getIdByExternalIid($company->iid);
        
        $this->assertSame($id, $company->id);
    
    }
    
    
}
