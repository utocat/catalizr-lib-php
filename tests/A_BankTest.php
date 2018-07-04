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
 * @group banck
 */
class A_BankTest extends TestMain {

    public function testGetAll() {
        $bancks = $this->api->banks->getAll();
        $this->assertContainsOnlyInstancesOf('\Catalizr\Entity\Banks', $bancks);
        foreach ($bancks as $banck) {
            $this->assertNotEmpty($banck->name);
            $this->assertNotEmpty($banck->logo);
        }
    }
}
