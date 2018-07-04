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
 * @group fundraisings
 */
class D_FundraisingsTest extends TestMain {

    /**
     * @var \Catalizr\Entity\Fundraisings
     */
    static $fundraisingHaveIid;

    /**
     * @var \Catalizr\Entity\Fundraisings[]
     */
    static $fundraisings;

    /**
     * @var \Catalizr\Entity\Fundraisings
     */
    static $fundraising;


    public function testCreate()
    {
        $fundraisingData = array(
            'name'=> 'myFundraising',
            'part_amount' => 100,
            'minimum_investment'=> 1000,
            'fee' => 1,
            'start_date' => date('c',time() + 50000),
            'end_date' => date('c',time() + 70000),
            'amount_total' => 10000,
            'description'=> 'test lib php',
        );

        self::$fundraisings[] = new \Catalizr\Entity\Fundraisings($fundraisingData);
        self::$fundraisings[] = new \Catalizr\Entity\Fundraisings($fundraisingData);
        self::$fundraisings[] = new \Catalizr\Entity\Fundraisings($fundraisingData);
        self::$fundraisings[] = new \Catalizr\Entity\Fundraisings($fundraisingData);

        $this->api->companies->createFundraisingsByCompany(C_CompaniesTest::$companies[0], self::$fundraisings[0]);
        $this->api->companies->createFundraisingsByExternalCompanyId(C_CompaniesTest::$companies[1]->iid, self::$fundraisings[1]);
        $this->api->companies->createFundraisingsByCompanyId(C_CompaniesTest::$companies[2]->id, self::$fundraisings[2]);
        $this->api->companies->createFundraisingsByCompanyId(C_CompaniesTest::$companies[3]->id, self::$fundraisings[3]);
    }

    public function testCreateFull()
    {
        $fundraisingData = array(
            'name'=> 'myFundraising',
            'part_amount' => 100.5,
            'minimum_investment'=> 1000,
            'fee' => 1,
            'description'=> 'test lib php',
            'amount_total' => 10000,
            'start_date' => date('c',time() + 50000),
            'end_date' => date('c',time() + 70000),
            'funds_type' =>'CREATE',
            'part_nature' => 'PARTS_SOCIALES',
            'part_type' => 'ACTION_INVEST',
            'iid'=> time()
        );
        $fundraising = new \Catalizr\Entity\Fundraisings($fundraisingData);

        $this->api->companies->createFundraisingsByCompanyId(C_CompaniesTest::$companies[4]->id, $fundraising);

        self::$fundraising = $fundraising;

        return $fundraising;
    }

    /**
     * @depends testCreateFull
     */
    public function testCreateErrorApi()
    {
        date_default_timezone_set('Europe/Paris');
        $fundraisingData = array(
            'name'=> 'myFundraising',
            'part_amount' => 100,
            'minimum_investment'=> 1000,
            'fee' => 1,
            'start_date' => date('c',time() +50000),
            'end_date' => date('c',time() +70000),
            'amount_total' => 10000,
            'description'=> 'test lib php',
        );
        $fundraising1 = new \Catalizr\Entity\Fundraisings($fundraisingData);

        try{
            $this->api->companies->createFundraisingsByCompany(C_CompaniesTest::$companies[0], $fundraising1);
        } catch (Exception $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('A fundraising is already open for this company', $ex->getMessage());
        }

        try{

            $this->api->companies->createFundraisingsByCompanyId('edfedfedfedfedfedfedfedf', $fundraising1);

        } catch (\Catalizr\Lib\HttpException $ex) {
          $this->assertSame(404, $ex->getCode(),'http code');
          $this->assertSame('Company not found', $ex->getMessage());
        }
        $fundraising2 = new \Catalizr\Entity\Fundraisings();

        try{
            $this->api->companies->createFundraisingsByCompany(C_CompaniesTest::$companies[0], $fundraising2);

        } catch (\Catalizr\Lib\HttpException $ex) {
          $this->assertSame(400, $ex->getCode(),'http code');
          $this->assertSame('"name" is required', $ex->getMessage());
        }
    }

    public function testGetError()
    {
        try {
            $this->api->fundraisings->getById('rrrrrrrrrrrrrrrrrrrrrrrr');
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"fundraising_id" must only contain hexadecimal characters', $ex->getMessage());
        }

        try {
            $this->api->fundraisings->getById('edfedfedfedfedfedfedfedf');
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');
            $this->assertSame('Fundraising not found', $ex->getMessage());
        }
    }

    /**
     * @depends testCreateFull
     */
    public function testGet(\Catalizr\Entity\Fundraisings $fundraising)
    {
        // get by id
        self::$fundraisingHaveIid = $this->api->fundraisings->getById($fundraising->id);
        // get by iid
        $fundraisingGetIid = $this->api->fundraisings->getByExternalId($fundraising->iid);
        $this->assertEquals(self::$fundraisingHaveIid,$fundraisingGetIid);

        $this->assertSame(self::$fundraisingHaveIid->name, 'myFundraising');
        $this->assertSame(self::$fundraisingHaveIid->part_amount, 100.5);
        $this->assertSame(self::$fundraisingHaveIid->minimum_investment, 1000);
        $this->assertSame(self::$fundraisingHaveIid->fee, 1);
        $this->assertSame(self::$fundraisingHaveIid->amount_total, 10000);
        $this->assertSame(self::$fundraisingHaveIid->description, 'test lib php');
        $this->assertSame(self::$fundraisingHaveIid->funds_type, 'CREATE');
        $this->assertSame(self::$fundraisingHaveIid->part_nature, 'PARTS_SOCIALES');
        $this->assertSame(self::$fundraisingHaveIid->part_type, 'ACTION_INVEST');

        $this->assertInternalType('string',self::$fundraisingHaveIid->start_date);
        $this->assertInternalType('string',self::$fundraisingHaveIid->end_date);
        $this->assertInternalType('string',self::$fundraisingHaveIid->createdAt);
        $this->assertInternalType('string',self::$fundraisingHaveIid->updatedAt);


        $this->assertSame(self::$fundraisingHaveIid->id, $fundraising->id);
        $this->assertSame(self::$fundraisingHaveIid->iid, $fundraising->iid);

        // get all ids
        $ids1 = $this->api->companies->getFundraisingsIdByCompanyId(C_CompaniesTest::$companie->id);
        $ids2 = $this->api->companies->getFundraisingsIdByCompany(C_CompaniesTest::$companie);
        $ids3 = $this->api->companies->getFundraisingsIdByExternalCompanyId(C_CompaniesTest::$companie->iid);


        $this->assertEquals($ids1,$ids2);
        $this->assertEquals($ids2,$ids3);

        $this->assertContainsOnly('string', $ids1->items);

        // get id by iid

        $id = $this->api->fundraisings->getIdByExternalIid($fundraising->iid);

        $this->assertSame($id, $fundraising->id);
    }

    /**
     * @test
     * @throws \Catalizr\Lib\HttpException
     */
    public function update()
    {
        $company = new \Catalizr\Entity\Companies();

        $company->name = 'Ludo';
        $company->legal_form = 'SAS';
        $company->phone = '0123456789';
        $company->address = 'Doge B, 4 Avenue des Saules';
        $company->zip = '59000';
        $company->city = 'Lille';
        $company->country = 'France';
        $company->in_progress = false;
        $company->siren = strval(time() - 1000000000);
        $company->email= 'support@catalizr.eu';
        $company->iid= time();
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

        $fundraisingData = array(
            'name'=> 'myFundraising To update',
            'part_amount' => 100,
            'minimum_investment'=> 1000,
            'fee' => 1,
            'description'=> 'test lib php',
            'amount_total' => 10000,
            'start_date' => date('c',time() + 50000),
            'end_date' => date('c',time() + 70000),
            'funds_type' =>'CREATE',
            'part_nature' => 'PARTS_SOCIALES',
            'part_type' => 'ACTION_INVEST',
            'iid'=> time()
        );
        $fundraising = new \Catalizr\Entity\Fundraisings($fundraisingData);

        $this->api->companies->createFundraisingsByCompanyId($company->id, $fundraising);

        $fundraising->name = 'myFundraising UPDATED';
        $this->api->fundraisings->update($fundraising);

        $fundraisingUpdated = $this->api->fundraisings->getById($fundraising->id);
        $this->assertEquals('myFundraising UPDATED', $fundraisingUpdated->name);
    }
}
