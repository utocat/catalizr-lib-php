<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 27/06/18
 * Time: 16:23
 */
require_once 'TestMain.php';

class M_Investor2Test extends TestMain
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
        $investmentsObject = $this->api->investors->getAllInvestmentsIds(B_InvestorTest::$investor);
        $this->assertSortedPagination($investmentsObject);
        $this->assertAttributeNotEmpty('items', $investmentsObject);
        $this->assertAttributeContainsOnly('string', 'items', $investmentsObject);
    }
}
