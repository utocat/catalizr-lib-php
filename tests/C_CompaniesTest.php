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
     * @var array(\Catalizr\Entity\Companies)
     */
    static $companies;
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

    public function testCreate($siren=null) {
        $company = new \Catalizr\Entity\Companies();

        $company->name = 'utocat';
        $company->legal_form = 'SAS';
        $company->phone = '0123456789';
        $company->address = 'Doge B, 4 Avenue des Saules';
        $company->zip = '59000';
        $company->city = 'Lille';
        $company->country = 'France';
        $company->in_progress = false;
        $company->siren = strval(time() - 1000000000);

        $this->api->companies->create($company);
        $this->assertInternalType('string', $company->id);

        return $company;

    }
    
    /**
     * 
     * @depends testCreate
     */
    public function testCreateFull(\Catalizr\Entity\Companies $companyAfter, $createMany=true) {
        $company = new \Catalizr\Entity\Companies();

        $company->name = 'utocat';
        $company->legal_form = 'SAS';
        $company->phone = '0123456789';
        $company->address = 'Doge B, 4 Avenue des Saules';
        $company->zip = '59000';
        $company->city = 'Lille';
        $company->country = 'France';
        $company->in_progress = false;
        $company->siren = strval($companyAfter->siren +1);
        $company->email= 'support@catalizr.eu';
        $company->iid= isset($companyAfter->iid) ? $companyAfter->iid+1 : time();
        $company->boss_title= 'Mr';
        $company->boss_name= 'bossName';
        $company->boss_surname= 'bossSurname';
        $company->boss_phone='1234567890';
        $company->boss_status='PDG';
        $company->bank_name = 'test';
        $company->bank_address = 'test';
        $company->iban='FR1420041010050500013M02606';
        $company->bic_swift='AGRIFRPP867';
        $this->api->companies->create($company);
        $this->assertInternalType('string', $company->id);
        $this->assertInternalType('string', $company->iid);
        if($createMany)
        {
            self::$companies[] = $this->testCreateFull($company,false);
            self::$companies[] = $this->testCreateFull(end( self::$companies),false);
            self::$companies[] = $this->testCreateFull(end( self::$companies),false);

        }
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
        self::$companies[] = $this->api->companies->getById($company->id);
        self::$companie = end(self::$companies);

        // get by iid
        $companyGetIid = $this->api->companies->getByExternalId($company->iid);
        $this->assertEquals(self::$companie,$companyGetIid);

        $this->assertSame(self::$companie->name, 'utocat');
        $this->assertSame(self::$companie->legal_form, 'SAS');
        $this->assertSame(self::$companie->phone, '0123456789');

        $this->assertSame(self::$companie->address, 'Doge B, 4 Avenue des Saules');
        $this->assertSame(self::$companie->zip, '59000');
        $this->assertSame(self::$companie->city, 'Lille');
        $this->assertSame(self::$companie->country, 'France');
        $this->assertSame(self::$companie->in_progress, false);
        $this->assertSame(self::$companie->email, 'support@catalizr.eu');

        $this->assertSame(self::$companie->boss_title, 'Mr');
        $this->assertSame(self::$companie->boss_name, 'bossName');
        $this->assertSame(self::$companie->boss_surname, 'bossSurname');
        $this->assertSame(self::$companie->boss_phone, '1234567890');
        $this->assertSame(self::$companie->boss_status, 'PDG');
        
        $this->assertSame(self::$companie->bank_name, 'test');
        $this->assertSame(self::$companie->bank_address, 'test');
        $this->assertSame(self::$companie->iban, 'FR1420041010050500013M02606');
        $this->assertSame(self::$companie->bic_swift, 'AGRIFRPP867');
        $this->assertInternalType('string',self::$companie->createdAt);
        $this->assertInternalType('string',self::$companie->updatedAt);

        
        $this->assertSame(self::$companie->siren, $company->siren);
        $this->assertSame(self::$companie->id, $company->id);
        $this->assertSame(self::$companie->iid, $company->iid);

        // get all ids
        $ids = $this->api->companies->getAllid();

        $this->assertContainsOnly('string', $ids->items);

        // get id by iid

        $id = $this->api->companies->getIdByExternalIid($company->iid);
        
        $this->assertSame($id, $company->id);
    
    }
    
    
}
