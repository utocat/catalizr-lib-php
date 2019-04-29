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

    public function testCreate() {
        $company = new \Catalizr\Entity\Companies();

        $company->name = 'utocat';
        $company->legal_form = 'SAS';
        $company->phone = '0123456789';
        $company->address = 'Doge B, 4 Avenue des Saules';
        $company->zip = '59000';
        $company->city = 'Lille';
        $company->country = 'France';
        $company->bank_name = 'AXA';
        $company->bank_address = 'test';
        $company->in_progress = false;
         $company->iban='FR'.time().rand();
        $company->bic_swift='AGRIFRPP867';
        $company->email = time().rand().'@catalizr.eu';
        $company->siren = strval(time() - 1000000000);

        $this->api->companies->create($company);
        $this->assertInternalType('string', $company->id);

        return $company;

    }

    /**
     *
     * @test
     *
     * @return \Catalizr\Entity\Companies
     * @throws \Catalizr\Lib\HttpException
     */
    public function createWithNoSiren() {
        $company = new \Catalizr\Entity\Companies();

        $company->name = 'Company with no SIREN';
        $company->legal_form = 'SAS';
        $company->phone = '0123456789';
        $company->address = 'Doge B, 4 Avenue des Saules';
        $company->zip = '59000';
        $company->city = 'Lille';
        $company->country = 'France';
        $company->in_progress = true;
        $company->iid = time().rand();
        $company->email = $company->iid.'@catalizr.eu';
        $company->boss_title = 'Mr';
        $company->boss_name = 'bossName';
        $company->boss_surname = 'bossSurname';
        $company->boss_phone ='1234567890';
        $company->boss_status ='PDG';
        $company->bank_name = 'AXA';
        $company->bank_address = 'test';
        $company->iban='FR'.$company->siren;
        $company->bic_swift='AGRIFRPP867';
        $this->api->companies->create($company);

        $this->assertInternalType('string', $company->id);
        $this->assertInternalType('string', $company->iid);

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
        $company->iid = 100000000000000 - microtime(true) * 1000;
        $company->email = $company->iid.'@catalizr.eu';
        $company->boss_title = 'Mr';
        $company->boss_name = 'bossName';
        $company->boss_surname = 'bossSurname';
        $company->boss_phone = '1234567890';
        $company->boss_status = 'PDG';
        $company->bank_name = 'AXA';
        $company->bank_address = 'test';
        $company->iban = 'FR'.$company->siren;
        $company->bic_swift = 'AGRIFRPP867';
        $this->api->companies->create($company);
        $this->assertInternalType('string', $company->id);
        $this->assertInternalType('string', $company->iid);
        if($createMany)
        {
            self::$companies[] = $this->testCreateFull($company,false);
            self::$companies[] = $this->testCreateFull(end( self::$companies),false);
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
            $this->assertSame('Company edfedfedfedfedfedfedfedf not found', $ex->getMessage());
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

        $this->assertGetCompany(self::$companie);

        $this->assertSame(self::$companie->siren, $company->siren);
        $this->assertSame(self::$companie->id, $company->id);
        $this->assertSame(self::$companie->iid, $company->iid);

        // get id by iid
        $id = $this->api->companies->getIdByExternalIid($company->iid);

        $this->assertSame($id, $company->id);
    }

    /**
     * @test
     * @depends testCreateFull
     * @param \Catalizr\Entity\Companies $company
     * @throws \Catalizr\Lib\HttpException
     */
    public function getBySiren(\Catalizr\Entity\Companies $company) {
        $companyBySiren = $this->api->companies->getBySiren($company->siren);
        $this->assertGetCompany($companyBySiren);
    }

    /**
     * @test
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllIdsWithPagination() {
        $pagination = new \Catalizr\Pagination(['page' => 1, 'per_page' => 3]);
        $companies = $this->api->companies->getAllIds($pagination);
        $this->assertSortedPagination($companies);
        $this->assertAttributeCount(3, 'items', $companies);
    }

    /**
     * @test
     * @depends testCreateFull
     * @param \Catalizr\Entity\Companies $company
     * @throws \Catalizr\Lib\HttpException
     */
    public function searchByName(\Catalizr\Entity\Companies $company)
    {
        $searchResult = $this->api->companies->searchByName($company->name);
        $this->assertInternalType('array', $searchResult);
        $this->assertNotEmpty($searchResult);
        $this->assertEquals('utocat', $searchResult[0]->name);
        $this->assertEquals('59000', $searchResult[0]->zip);
        $this->assertEquals('Lille', $searchResult[0]->city);
    }

    /**
     * @test
     * @depends createWithNoSiren
     * @param \Catalizr\Entity\Companies $company
     * @throws \Catalizr\Lib\HttpException
     */
    public function searchByNameWithNoSiren(\Catalizr\Entity\Companies $company)
    {
        $searchResult = $this->api->companies->searchByName($company->name, false);
        $this->assertInternalType('array', $searchResult);
        $this->assertNotEmpty($searchResult);
        $this->assertEquals('Company with no SIREN', $searchResult[0]->name);
    }

    /**
     * @test
     * @depends testCreateFull
     * @param \Catalizr\Entity\Companies $company
     * @throws \Catalizr\Lib\HttpException
     */
    public function searchBySiren(\Catalizr\Entity\Companies $company)
    {
        $searchResult = $this->api->companies->searchBySiren($company->siren);
        $this->assertInternalType('array', $searchResult);
        $this->assertNotEmpty($searchResult);
        $this->assertEquals('utocat', $searchResult[0]->name);
        $this->assertEquals('59000', $searchResult[0]->zip);
        $this->assertEquals('Lille', $searchResult[0]->city);
    }

    /**
     * @test
     * @depends testCreateFull
     * @param \Catalizr\Entity\Companies $company
     * @throws \Catalizr\Lib\HttpException
     */
    public function update(\Catalizr\Entity\Companies $company)
    {
        $originalCompany = $this->api->companies->getById($company->id);
        $originalCompany->name = 'utocat 2';
        $this->api->companies->update($originalCompany);
        $updatedCompany = $this->api->companies->getById((string)$originalCompany->id);
        $this->assertNotEmpty($updatedCompany->updatedAt);
        $this->assertNotEquals($updatedCompany->updatedAt, $originalCompany->updatedAt);
        unset($originalCompany->updatedAt);
        unset($updatedCompany->updatedAt);
        unset($originalCompany->modified);
        unset($updatedCompany->modified);
        $this->assertEquals($updatedCompany, $originalCompany);

        // reset Company
        $originalCompany->name = 'utocat';
        $this->api->companies->update($originalCompany);
    }

    /**
     * @param \Catalizr\Entity\Companies $company
     */
    private function assertGetCompany(\Catalizr\Entity\Companies $company) {
        $this->assertSame($company->name, 'utocat');
        $this->assertSame($company->legal_form, 'SAS');
        $this->assertSame($company->phone, '0123456789');
        $this->assertSame($company->address, 'Doge B, 4 Avenue des Saules');
        $this->assertSame($company->zip, '59000');
        $this->assertSame($company->city, 'Lille');
        $this->assertSame($company->country, 'France');
        $this->assertSame($company->in_progress, false);
        $this->assertSame($company->email, $company->iid.'@catalizr.eu');
        $this->assertSame($company->boss_title, 'Mr');
        $this->assertSame($company->boss_name, 'bossName');
        $this->assertSame($company->boss_surname, 'bossSurname');
        $this->assertSame($company->boss_phone, '1234567890');
        $this->assertSame($company->boss_status, 'PDG');
        $this->assertSame($company->bank_name, 'AXA');
        //$this->assertSame($company->bank_address, 'test');
        $this->assertSame($company->iban, 'FR'.$company->siren);
        $this->assertSame($company->bic_swift, 'AGRIFRPP867');

        $this->assertInternalType('string',$company->createdAt);
        $this->assertInternalType('string',$company->updatedAt);

        $this->assertNotEmpty($company->siren);
    }
}
