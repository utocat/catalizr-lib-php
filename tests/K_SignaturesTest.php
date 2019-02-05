<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 25/06/18
 * Time: 17:43
 */
require_once 'TestMain.php';

class K_SignaturesTest extends TestMain
{
    /**
     * @var \Catalizr\Entity\Investments
     */
    static $investment;

    /**
     * @test
     * @return \Catalizr\Entity\SignatureLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function createLink()
    {
        $investorInvestments = $this->api->investors->getAllInvestmentsIds(B_InvestorTest::$investor);
        self::$investment = $this->api->investments->getById(end($investorInvestments->items));
        
        $data = [
            "documents" => [
                [
                    "id" => self::$investment->documents[0]->id,
                    "read_only" => true
                ]
            ],
            "user" => [
                "name" => B_InvestorTest::$investor->name,
                "firstname" => B_InvestorTest::$investor->surname,
                "email" => B_InvestorTest::$investor->email,
                "phone" => B_InvestorTest::$investor->phone
            ]
        ];

        $link = $this->api->signatures->createLink($data);
        $this->assertObjectHasAttribute('id', $link);
        $this->assertObjectHasAttribute('url', $link);
        $this->assertAttributeNotEmpty('id', $link);
        $this->assertAttributeNotEmpty('url', $link);

        return new \Catalizr\Entity\SignatureLink($link);
    }
        /**
     * @test
     * @depends createLink
     * @param \Catalizr\Entity\SignatureLink $signatureLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocusignEnvelope(\Catalizr\Entity\SignatureLink $signatureLink)
    {
        $data= ["callback"=> "https://google.fr" ];
        $response = $this->api->signatures->createDocusignEnvelope($signatureLink, $data);

         $this->assertInternalType('string', $response->envelope_url);
         $this->assertInternalType('string', $response->envelope_id);
        return $signatureLink;
    }
    /**
     * @test
     * @depends createDocusignEnvelope
     * @param \Catalizr\Entity\SignatureLink $signatureLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLink(\Catalizr\Entity\SignatureLink $signatureLink)
    {
        $link = $this->api->signatures->getLinkById($signatureLink->id);
        $this->assertInternalType('string', $link->url_docusign);

        $this->assertEquals(self::$investment->documents[0]->id, $link->documents[0]);
    }

    /**
     * @test
     * @depends createLink
     * @param \Catalizr\Entity\SignatureLink $signatureLink
     * @throws \Catalizr\Lib\HttpException
     */
    /*public function sendLink(\Catalizr\Entity\SignatureLink $signatureLink)
    {
        $emailsData = [
            'emails' => [
                'userA@utocat.fr',
                'userB@utocat.fr',
            ],
            "mail_subject" => "Subject of the message",
            "mail_body" => "Explicit content of the message"
        ];

        $result = $this->api->signatures->sendLink($signatureLink, $emailsData);

        $this->assertEquals($emailsData['emails'], $result->emails);
        $this->assertEquals($signatureLink->id, $result->id);
        $this->assertEquals($signatureLink->url, $result->url);
    }*/
}
