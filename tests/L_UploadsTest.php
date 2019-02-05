<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 26/06/18
 * Time: 10:34
 */
class L_UploadsTest extends TestMain
{
    /**
     * @test
     * @return \Catalizr\Entity\UploadLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function createLink()
    {
        $uploadLink = new \Catalizr\Entity\UploadLink([
            'datas' => [
                'documents_type' => [
                    \Catalizr\Entity\UploadReferenceDocument::TYPE_LETTRE_ENGAGEMENT,
                ],
                'entities_id' => [
                    'investment' => E_InvestmentsTest::$investment->id,
                ],
            ]
        ]);

        $this->api->uploads->createLink($uploadLink);

        $this->assertAttributeNotEmpty('id', $uploadLink);
        $this->assertAttributeNotEmpty('url', $uploadLink);

        return $uploadLink;
    }

    // Dependant tests
    /**
     * @test
     * @depends createLink
     *
     * @param \Catalizr\Entity\UploadLink $uploadLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLinkData(\Catalizr\Entity\UploadLink $uploadLink)
    {
        $link = $this->api->uploads->getLinkData($uploadLink);

        $this->assertEquals($uploadLink, $link);
    }

    /**
     * @test
     * @depends createLink
     *
     * @param \Catalizr\Entity\UploadLink $uploadLink
     * @throws \Catalizr\Lib\HttpException
     */
    /*public function sendLink(\Catalizr\Entity\UploadLink $uploadLink)
    {
        $emailData = [
            'emails' => [
                'userA@utocat.fr',
                'userB@utocat.fr',
            ],
            "mail_subject" => "Subject of the message",
            "mail_body" => "Explicit content of the message"
        ];

        $sent = $this->api->uploads->sendLink($uploadLink->id, $emailData);

        $this->assertObjectHasAttribute('id', $sent);
        $this->assertEquals($uploadLink->id, $sent->id);
        $this->assertObjectHasAttribute('url', $sent);
        $this->assertEquals($uploadLink->url, $sent->url);
        $this->assertObjectHasAttribute('emails', $sent);
        $this->assertInternalType('array', $sent->emails);
    }*/
}
