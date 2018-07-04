<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 25/06/18
 * Time: 16:43
 */

namespace Catalizr\Api;

/**
 * Description of Class Signatures
 * @package Catalizr\Api
 */
class Signatures extends \Catalizr\Lib\Api
{
    /**
     * @var string
     */
    static $classEntity = '\Catalizr\Entity\SignatureLink';

    /**
     * @var string
     */
    static $prefixTag = 'signatures';


    /**
     * Creates a Docusign envelope from the given signature link
     *
     * @param \Catalizr\Entity\SignatureLink $signatureLink
     * @param array $envelopeData
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocusignEnvelope(\Catalizr\Entity\SignatureLink $signatureLink, $envelopeData)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_envelope_post', $envelopeData, [$signatureLink->id]);
    }

    /**
     * Generate a link to signature
     *
     * @param array $data
     * Example:
     * $data => [
     *      "documents" => [
     *          [
     *              "id" => "5b297b1bdbbe442486de7d02",
     *              "read_only" => true
     *          ],
     *          [
     *              "id" => "5b297b1bdbbe442486de7d03",
     *              "read_only" => true
     *          ]
     *      ],
     *      "user" => [
     *          "name" => "Delpech",
     *          "firstname" => "Clementine",
     *          "email" => "1529445053412@utocat.com",
     *          "phone" => "+330123456789"
     *      ]
     * ];
     * @return \Catalizr\Entity\SignatureLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function createLink($data)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_post', $data);
    }

    /**
     * Get the signature link by its id
     *
     * @param $linkId
     * @return \Catalizr\Entity\SignatureLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLinkById($linkId)
    {
        return parent::getById(self::$prefixTag . '_links', self::$classEntity, $linkId);
    }

    /**
     * Send signature link by email
     *
     * @param \Catalizr\Entity\SignatureLink $signatureLink
     * @param array $emailsData
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function sendLink(\Catalizr\Entity\SignatureLink $signatureLink, $emailsData)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_send_post', $emailsData, [$signatureLink->id]);
    }
}
