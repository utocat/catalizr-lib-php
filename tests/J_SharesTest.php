<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 22/06/18
 * Time: 14:13
 */
require_once 'TestMain.php';

class J_SharesTest extends TestMain
{
    /**
     * @test
     * @throws \Catalizr\Lib\HttpException
     */
    public function createSharesLink()
    {
        $data = [
            "method" => "EMAIL",
            "company_id" => (string) C_CompaniesTest::$companie->id,
        ];

        $shareLink = $this->api->shares->createSharesLink($data);

        $this->assertObjectHasAttribute('id', $shareLink);
        $this->assertAttributeNotEmpty('id', $shareLink);
        $this->assertObjectHasAttribute('url', $shareLink);
        $this->assertAttributeNotEmpty('url', $shareLink);

        return $shareLink;
    }

    /**
     * @test
     * @depends createSharesLink
     * @param object $shareLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLink($shareLink)
    {
        $links = $this->api->shares->getLink($shareLink->id);

        $this->assertInternalType('array', $links);

        if (count($links) > 0) {
            foreach ($links as $link) {
                $this->assertObjectHasAttribute('fundraising_id', $link);
                $this->assertAttributeNotEmpty('fundraising_id', $link);
                $this->assertObjectHasAttribute('value', $link);
                $this->assertAttributeNotEmpty('value', $link);
                $this->assertObjectHasAttribute('investments', $link);
                $this->assertInternalType('array', $link->investments);
            }
        }
    }

    /**
     * @test
     * @depends createSharesLink
     * @param object $shareLink
     * @throws \Catalizr\Lib\HttpException
     */
    /*public function sendSharesLinkByEmail($shareLink)
    {
        $data = [
            "emails" => ["email1@utocat.fr", "email2@utocat.fr"],
            "mail_subject" => "Subject of the mail",
            "mail_body" => "Content of the mail",
        ];

        $sendSharelink = $this->api->shares->sendSharesLinkByEmail($shareLink->id, $data);

        $this->assertObjectHasAttribute('id', $sendSharelink);
        $this->assertEquals($shareLink->id, $sendSharelink->id);
        $this->assertObjectHasAttribute('url', $sendSharelink);
        $this->assertEquals($shareLink->url, $sendSharelink->url);
        $this->assertObjectHasAttribute('emails', $sendSharelink);
        $this->assertInternalType('array', $sendSharelink->emails);
    }*/
}
