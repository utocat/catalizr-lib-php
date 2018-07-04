<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 27/06/18
 * Time: 16:34
 */
require_once 'TestMain.php';

class N_Fundraisings2Test extends TestMain
{
    /**
     * @test
     *
     * Need that E_InvestmentsTest had been ran
     *
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllInvestmentsIds()
    {
        $allInvestments = $this->api->fundraisings->getAllInvestmentsIds(D_FundraisingsTest::$fundraising);
        $this->assertSortedPagination($allInvestments);
        $this->assertAttributeNotEmpty('items', $allInvestments);
        $this->assertAttributeContainsOnly('string', 'items', $allInvestments);
    }
}
