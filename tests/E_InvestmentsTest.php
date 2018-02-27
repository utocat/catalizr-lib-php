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
 * @group investments
 */
class E_InvestmentsTest extends TestMain {
    /**
     *
     * @var \Catalizr\Entity\Investments
     */
    static $investment;
    
    public function testCreateErrorApi() {
        $investment1 = new \Catalizr\Entity\Investments();
        try{
            $this->api->investments->create($investment1);

        } catch (Exception $ex) {
            $this->assertSame('fundraising or fundraising_id or fundraising_external_id is not set in investment', $ex->getMessage());
        }
        
        $investment1->fundraising_id = 'edfedfedfedfedfedfedfedf';
        try{
            $this->api->investments->create($investment1);

        } catch (Exception $ex) {
            $this->assertSame('investor or investor_id or investor_external_id is not set in investment', $ex->getMessage());
        }
        $investment1->investor = B_InvestorTest::$investor;
        $investment1->payment_mode = 'PEA';
        $investment1->nb_part = 2;
        $investment1->bank_name ='MySuperBanck';
        
        try{
            $this->api->investments->create($investment1);

        } catch (Exception $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');

            $this->assertSame('Fundraising not found', $ex->getMessage());
        }
        $investment2 = new \Catalizr\Entity\Investments();
        $investment2->fundraising_external_id = D_FundraisingsTest::$fundraisingHaveIid->iid;
        $investment2->investor = B_InvestorTest::$investor;
        try{
            $this->api->investments->create($investment2);

        } catch (\Catalizr\Lib\HttpException $ex) {
          $this->assertSame(400, $ex->getCode(),'http code');
          $this->assertSame('"payment_mode" is required', $ex->getMessage());
        }
    }
    
    public function testCreate() {
        
        $investment1 = new \Catalizr\Entity\Investments();
        $investment1->fundraising_external_id = D_FundraisingsTest::$fundraisingHaveIid->iid;
        $investment1->investor = B_InvestorTest::$investor;
        $investment1->payment_mode = 'PEA';
        $investment1->nb_part = 2;
        $investment1->bank_name ='MySuperBanck';
        
        $return = $this->api->investments->create($investment1);
        $this->assertContainsOnly('string', $return->documents_created);
        
        foreach ($return->documents_required as $doc) {
            $this->assertInternalType('string',$doc->type);
            $this->assertInternalType('string',$doc->entity);
        }
        
        $investment2 = new \Catalizr\Entity\Investments();
        $investment2->fundraising_id = D_FundraisingsTest::$fundraisings[0]->id;
        $investment2->investor_external_id = B_InvestorTest::$investor->iid;
        $investment2->payment_mode = 'PEA';
        $investment2->nb_part = 2;
        $investment2->bank_name ='MySuperBanck';
        
        $this->api->investments->create($investment2);
        
        $investment3 = new \Catalizr\Entity\Investments();
        $investment3->fundraising = D_FundraisingsTest::$fundraisings[1];
        $investment3->investor_id = B_InvestorTest::$investor->id;
        $investment3->payment_mode = 'PEA';
        $investment3->nb_part = 2;
        $investment3->bank_name ='MySuperBanck';
        
        $this->api->investments->create($investment3);
    }
    
    public function testCreateFull() {
        $investment = new \Catalizr\Entity\Investments();
        $investment->fundraising = D_FundraisingsTest::$fundraisings[2];
        $investment->investor = B_InvestorTest::$investor;
        $investment->payment_mode = 'PEA';
        $investment->nb_part = 2;
        $investment->bank_name ='MySuperBanck';
        $investment->bic_swift ='AGRIFRPP867';
        $investment->bank_address ='MyBankAddr';
        $investment->iban ='FR1420041010050500013M02606';
        $investment->iid =time();
        $this->api->investments->create($investment);

        return $investment;
    }
    
    
    public function testGetError() {
        try {
            $this->api->investments->getById('rrrrrrrrrrrrrrrrrrrrrrrr');

        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"investment_id" must only contain hexadecimal characters', $ex->getMessage());
        }

        try {
            $this->api->investments->getById('edfedfedfedfedfedfedfedf');

        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');
            $this->assertSame('Investment not found', $ex->getMessage());
        }
    }
    
    
    /**
     * 
     * @depends testCreateFull
     */
    public function testGet(\Catalizr\Entity\Investments $investment) {
        // get by id
        self::$investment = $this->api->investments->getById($investment->id);
        // get by iid
        $investmentGetIid = $this->api->investments->getByExternalId($investment->iid);
        $this->assertEquals(self::$investment,$investmentGetIid);

        $this->assertSame(self::$investment->fundraising_id, D_FundraisingsTest::$fundraisings[2]->id);
        $this->assertSame(self::$investment->investor_id, B_InvestorTest::$investor->id);
        $this->assertSame(self::$investment->payment_mode, 'PEA');
        $this->assertSame(self::$investment->nb_part, 2);
        $this->assertSame(self::$investment->bank_name, 'MySuperBanck');
        $this->assertSame(self::$investment->bic_swift, 'AGRIFRPP867');
        $this->assertSame(self::$investment->iban, 'FR1420041010050500013M02606');

        $this->assertInternalType('string',self::$investment->createdAt);
        $this->assertInternalType('string',self::$investment->updatedAt);

        
        $this->assertSame(self::$investment->id, $investment->id);
        $this->assertSame(self::$investment->iid, $investment->iid);


        // get id by iid

        $id = $this->api->investments->getIdByExternalIid($investment->iid);
        
        $this->assertSame($id, $investment->id);
    
    }
//    
}
