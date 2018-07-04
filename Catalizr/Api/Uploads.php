<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 26/06/18
 * Time: 10:01
 */
namespace Catalizr\Api;

use Catalizr\Entity\UploadReference;
use Catalizr\Entity\UploadReferenceDocument;

/**
 * Description of Class Uploads
 * @package Catalizr\Api
 */
class Uploads extends \Catalizr\Lib\Api
{
    /**
     * @var string
     */
    static $classEntity = '\Catalizr\Entity\UploadLink';

    /**
     * @var string
     */
    static $prefixTag = 'uploads';


    /**
     * Generate a link to upload documents
     *
     * @param \Catalizr\Entity\UploadLink $uploadLink
     * @return \Catalizr\Entity\UploadLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function createLink(&$uploadLink)
    {
        $result = $this->api->helperRequest->executeReq(self::$prefixTag . '_links_post', $uploadLink->datas);

        $uploadLink->id = $result->id;
        $uploadLink->url = $result->url;

        return $uploadLink;
    }

    /**
     * Specific URL for upload your file
     *
     * @param string $documentId id of the document
     * @return object
     * @throws \Catalizr\Lib\HttpException
     */
    public function getDocumentUrl($documentId)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_documents_post', null, [$documentId]);
    }

    /**
     * Get the upload link with documents that are not uploaded
     *
     * @param \Catalizr\Entity\UploadLink $uploadLink
     * @return \Catalizr\Entity\UploadLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLinkData($uploadLink)
    {
        $linkData = $this->api->helperRequest->executeReq(self::$prefixTag . '_links_get', null, [$uploadLink->id]);

        if (is_array($linkData)) {
            $uploadLink->datas = array_map(
                function ($linkDatum) {
                    $linkDatum->documents = array_map(
                        function ($document) {
                            return new UploadReferenceDocument($document);
                        },
                        $linkDatum->documents
                    );
                    return new UploadReference($linkDatum);
                },
                $linkData
            );
        }

        return $uploadLink;
    }

    /**
     * Send upload link by mail
     *
     * @param string $uploadLinkId Id of the upload link
     * @param array $emailData Datas needed to send a mail
     * @return object
     * @throws \Catalizr\Lib\HttpException
     */
    public function sendLink($uploadLinkId, $emailData)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_send_post', $emailData, [$uploadLinkId]);
    }
}
