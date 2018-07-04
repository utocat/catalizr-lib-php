<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 22/06/18
 * Time: 11:47
 */

namespace Catalizr\Api;


class Shares extends \Catalizr\Lib\Api
{
    /**
     * @var string
     */
    static $prefixTag = 'shares';

    /**
     * Generate a link to update investment shares
     *
     * @param array $data All datas needed to update shares for (keys "method" and "company_id" are required).
     * Example :
     * [
     *  "method" => "EMAIL",
     *  "company_id" => "<COMPANY_ID>"
     * ]
     * @return object Result object
     * @throws \Catalizr\Lib\HttpException
     */
    public function createSharesLink($data)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_post', $data);
    }

    /**
     * Get the shares link
     *
     * @param string $linkId Id of the shares link
     * @return object Result object
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLink($linkId)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_get', null, [$linkId]);
    }

    /**
     * Send shares of a link by email
     *
     * @param $linkId
     * @param array $data Data needed to send the email
     * Example :
     * [
     *  "emails" => ["email1@utocat.fr", "email2@utocat.fr"],
     *  "mail_subject" => "Subject of the mail",
     *  "mail_body" => "Content of the mail"
     * ]
     * @return object Result object
     * @throws \Catalizr\Lib\HttpException
     */
    public function sendSharesLinkByEmail($linkId, $data)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_send_post', $data, [$linkId]);
    }
}
