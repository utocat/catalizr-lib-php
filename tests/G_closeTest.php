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
 * @group document
 */
class G_closeTest extends TestMain {
        
    public function testFinishInvestment() {
        $this->api->investments->finishByInvestment(E_InvestmentsTest::$investment);
    }
    
    public function testCloseFundraising() {
        $this->api->fundraisings->closeByExternalFundraisingId(D_FundraisingsTest::$fundraisingHaveIid->iid);
    }
    public function createFundraisingAfertClose() {
                    
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
        $fundraising = new \Catalizr\Entity\Fundraisings($fundraisingData);
        $this->api->companies->createFundraisingsByCompanyId(D_FundraisingsTest::$fundraisingHaveIid->company, $fundraising);
    }
}
