<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'TestMain.php';
require_once 'TestData.php';

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


    public function testCreateErrorApi()
    {
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
        $investment1->category ='investment1Category';

        try{
            $this->api->investments->create($investment1);

        } catch (Exception $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');

            $this->assertSame('Fundraising not found', $ex->getMessage());
        }
        $investment2 = new \Catalizr\Entity\Investments();
        $investment2->fundraising_external_id = D_FundraisingsTest::$fundraisingHaveIid->iid;
        $investment2->investor = B_InvestorTest::$investor;
        $investment2->category ='investment2Category';
        try{
            $this->api->investments->create($investment2);

        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"payment_mode" is required', $ex->getMessage());
        }
    }

    public function testCreate()
    {
        $investment1 = new \Catalizr\Entity\Investments();
        $investment1->fundraising_external_id = D_FundraisingsTest::$fundraisingHaveIid->iid;
        $investment1->investor_id = B_InvestorTest::$investor->id;
        $investment1->investor = true;
        $investment1->payment_mode = 'PEA';
        $investment1->nb_part = 100;
        $investment1->part_amount = 125;
        $investment1->bank_name ='Crédit du Nord';
        $investment1->bank_address = '58 Boulevard Carnot - 62000 Arras - FRANCE';
        $investment1->iban = 'IE64BOFI9058381234567800000';
        $investment1->bic_swift = 'BOFIIE2DETC';
        $investment1->company = false;
        $investment1->nb_bons = 10;
        $investment1->category ='A';

        $return = $this->api->investments->create($investment1);
        $this->assertNotEmpty($return->documents_created);
        $this->assertContainsOnly('object', $return->documents_created);

        foreach ($return->documents_required as $doc) {
            $this->assertInternalType('string',$doc->type);
            $this->assertInternalType('string',$doc->entity);
        }

        $investment2 = new \Catalizr\Entity\Investments();
        $investment2->fundraising_id = D_FundraisingsTest::$fundraisings[0]->id;
        $investment2->investor_external_id = B_InvestorTest::$investor->iid;
        $investment2->payment_mode = 'PEA';
        $investment2->nb_part = 10;
        $investment2->part_amount = 125;
        $investment2->bank_name ='MySuperBanck';
        $investment2->category ='investment2Category';

        $this->api->investments->create($investment2);

        $investment3 = new \Catalizr\Entity\Investments();
        $investment3->fundraising = D_FundraisingsTest::$fundraisings[1];
        $investment3->investor_id = B_InvestorTest::$investor->id;
        $investment3->payment_mode = 'PEA';
        $investment3->nb_part = 10;
        $investment3->part_amount = 212;
        $investment3->bank_name ='MySuperBanck';
        $investment3->category ='investment3Category';

        $this->api->investments->create($investment3);
    }

    public function testCreateFull()
    {
        $investment = new \Catalizr\Entity\Investments();
        $investment->fundraising = D_FundraisingsTest::$fundraisings[2];
        $investment->investor_id = B_InvestorTest::$investor->id;
        $investment->payment_mode = 'PEA';
        $investment->nb_part = 10;
        $investment->part_amount = 122;
        $investment->bank_name ='MySuperBanck';
        $investment->bic_swift ='AGRIFRPP867';
        $investment->bank_address ='MyBankAddr';
        $investment->iban ='FR1420041010050500013M02606';
        $investment->iid = time().rand();
        $investment->category ='investmentCategory';
        $this->api->investments->create($investment);

        return $investment;
    }


    public function testGetError()
    {
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
     * @test
     */
    public function getAllStatus()
    {
        $allStatus = $this->api->investments->getAllStatus();
        $expectedStatus = [
            'WAITING_DOCUMENT',
            'NEW',
            'BANK_RECEIVED',
            'BANK_CONFIRMED',
            'EXPIRED',
            'REPORTED',
            'CLOSED',
            'INVESTOR_SIGNED',
            'COMPANY_SIGNED',
            'ALL_SIGNED',
            'PAYMENT_RECEIVED',
            'INVESTMENT_UPDATED',
            'INVESTMENT_CLOSED'
        ];

        $this->assertEquals($expectedStatus, $allStatus);

        return $allStatus;
    }

    /**
     * @test
     */
    public function getAllReportsTypes()
    {
        $allReportsTypes = $this->api->investments->getAllReportsTypes(new \Catalizr\Pagination());
        $this->assertPagination($allReportsTypes);
        $this->assertInternalType('array', $allReportsTypes->items);
        $this->assertAttributeContainsOnly('string', 'items', $allReportsTypes);
    }


    // Dependant tests

    /**
     * @test
     * @depends getAllStatus
     * @param array $allStatus
     * @throws \Catalizr\Lib\HttpException
     */
    public function collect($allStatus)
    {
        $collected = $this->api->investments->collect($allStatus[0], new \Catalizr\Pagination());
        $this->assertSortedPagination($collected);
        $this->assertAttributeNotEmpty('items', $collected);
    }

    /**
     * @test
     * @depends testCreateFull
     * @return \Catalizr\Entity\InvestmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function createLink()
    {
        $link = $this->api->investments->createLink();
        $this->assertObjectHasAttribute('id', $link);
        $this->assertObjectHasAttribute('url', $link);
        $this->assertAttributeNotEmpty('id', $link);
        $this->assertAttributeNotEmpty('url', $link);

        return $link;
    }

    /**
     * @test
     * @depends testCreateFull
     * @param \Catalizr\Entity\Investments $investments
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllReports(\Catalizr\Entity\Investments $investments)
    {
        $investmentReports = $this->api->investments->getAllReports($investments->id);
        $this->assertSortedPagination($investmentReports);
        $this->assertInternalType('array',$investmentReports->items);
        $this->assertAttributeContainsOnly('string', 'items', $investmentReports);
    }

    /**
     * TODO: wait for API fix (error 500 return by API)
     *
     * @param \Catalizr\Entity\Investments $investments
     * @throws \Catalizr\Lib\HttpException
     */
    public function getHistory(\Catalizr\Entity\Investments $investments)
    {
        $history = $this->api->investments->getHistory($investments, new \Catalizr\Pagination());

        $this->assertNotEmpty($history);
        foreach($history as $h) {
            $this->assertInternalType('string', $h->date);
            $this->assertInternalType('string', $h->status);
        }
    }

    /**
     * @test
     * @depends createLink
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLink(\Catalizr\Entity\InvestmentLink $investmentLink)
    {
        $link = $this->api->investments->getLink($investmentLink->id);
        $this->assertAttributeNotEmpty('url', $link);
        $this->assertEquals($investmentLink->url, $link->url);
    }

    /**
     * @test
     * @depends createLink
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @return \Catalizr\Entity\InvestmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function setStep(\Catalizr\Entity\InvestmentLink $investmentLink)
    {
        $this->api->investments->setStep($investmentLink, 'INIT');

        return $investmentLink;
    }

    /**
     * @test
     * @depends setStep
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLinkStep(\Catalizr\Entity\InvestmentLink $investmentLink)
    {
        $linkStep = $this->api->investments->getLinkStep($investmentLink->id);
        $this->assertObjectHasAttribute('date', $linkStep);
        $this->assertObjectHasAttribute('step', $linkStep);
        $this->assertInternalType('string', $linkStep->date);
        $this->assertInternalType('string', $linkStep->step);
        $this->assertEquals('INIT', $linkStep->step);
    }

    /**
     * @depends testCreateFull
     */
    public function testGet(\Catalizr\Entity\Investments $investment)
    {
        // get by id
        self::$investment = $this->api->investments->getById($investment->id);
        // get by iid
        $investmentGetIid = $this->api->investments->getByExternalId($investment->iid);
        $this->assertEquals(self::$investment,$investmentGetIid);

        $this->assertSame(self::$investment->fundraising_id, D_FundraisingsTest::$fundraisings[2]->id);
        $this->assertSame(self::$investment->investor_id, B_InvestorTest::$investor->id);
        $this->assertSame(self::$investment->payment_mode, 'PEA');
        $this->assertSame(self::$investment->nb_part, 10);
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

    /**
     * @test
     * @depends createLink
     *
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function sendLink(\Catalizr\Entity\InvestmentLink $investmentLink)
    {
        $emailParams = [
            "emailInvestor" => "support@catalizr.eu",
            "mail_subject" => "Subject of the message",
            "mail_body" => "Explicit content of the message",
        ];

        $resultObject = $this->api->investments->sendLink($investmentLink, $emailParams);

        $this->assertObjectHasAttribute('id', $resultObject);
        $this->assertObjectHasAttribute('url', $resultObject);
        $this->assertObjectHasAttribute('emailInvestor', $resultObject);
        $this->assertEquals($investmentLink->id, $resultObject->id);
        $this->assertNotEmpty($resultObject->url);
        $this->assertEquals($emailParams['emailInvestor'], $resultObject->emailInvestor);
    }

    /**
     * @test
     * @depends createLink
     *
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @return \Catalizr\Entity\InvestmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function setLinkDocument(\Catalizr\Entity\InvestmentLink $investmentLink)
    {
        $documentData = array_merge(TestData::$pdfBase64, ["type" => "STATUTS"]);

        $resultObject = $this->api->investments->setLinkDocument($investmentLink, $documentData);

        $this->assertObjectHasAttribute('id', $resultObject);
        $this->assertObjectHasAttribute('url', $resultObject);
        $this->assertNotEmpty($resultObject->id);
        $this->assertNotEmpty($resultObject->url);

        return $investmentLink;
    }

    /**
     * @test
     * @depends testCreateFull
     * @depends createLink
     *
     * @param \Catalizr\Entity\Investments $investment
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @return void
     * @throws \Catalizr\Lib\HttpException
     */
    public function updateLink(\Catalizr\Entity\Investments $investment, \Catalizr\Entity\InvestmentLink $investmentLink)
    {
        $investmentLink->investment_id = $investment->id;
        $now = time('now');
        $investmentLink->open_date = $now;

        $this->api->investments->updateLink($investmentLink);
        $updatedLink = $this->api->investments->getLink($investmentLink->id);
        $this->assertEquals($investmentLink->investment_id, $updatedLink->investment_id);
        $this->assertEquals(substr((string) $now, 0, 7), (string) strtotime($updatedLink->open_date));
    }

    /**
     * @test
     * @depends setLinkDocument
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLinkDocumentsUrl(\Catalizr\Entity\InvestmentLink $investmentLink)
    {
        $documents = $this->api->investments->getLinkDocumentsUrl($investmentLink->id);
        $this->assertInternalType('array', $documents);
        foreach ($documents as $doc) {
            $this->assertObjectHasAttribute('type_document', $doc);
            $this->assertAttributeInternalType('string', 'type_document', $doc);
            $this->assertAttributeNotEmpty('type_document', $doc);
            $this->assertObjectHasAttribute('url', $doc);
            $this->assertAttributeInternalType('string', 'url', $doc);
            $this->assertAttributeNotEmpty('url', $doc);
        }
    }
}
