<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 28/06/18
 * Time: 10:10
 */
class O_Investments2Test extends TestMain
{
    /**
     * @test
     * TODO: API seems to return nothing, check with API team if it's normal.
     *
     * Need that F_DocumentTest had been ran
     *
     * @throws \Catalizr\Lib\HttpException
     */
    public function generateDocumentAttestation()
    {
        $this->api->investments->generateDocumentsAttestation(E_InvestmentsTest::$investment);
    }

    /**
     * @test
     *
     * Need that F_DocumentTest had been ran
     *
     * @throws \Catalizr\Lib\HttpException
     */
    public function confirmError()
    {
        try {
            $this->api->investments->confirm(E_InvestmentsTest::$investment);
        } catch (\Catalizr\Lib\HttpException $e) {
            $this->assertEquals('The investment is not ready to be confirmed' ,$e->getMessage());
        }
    }

    // TODO: test with confirm with "forceConfirm" = true, but need that API has a route to update the investment status
}
