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
        
    public function testFinishInevstment() {
        $this->api->investments->finishByInvestment(E_InvestmentsTest::$investment);
    }
    
    public function testCLoseFundraising() {
        
        $this->api->fundraisings->closeByExternalFundraisingId(D_FundraisingsTest::$fundraisingHaveIid->iid);
    }
}
