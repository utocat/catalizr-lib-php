<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 19/06/18
 * Time: 17:16
 */

namespace Catalizr\Api;

use Catalizr\Lib\Api;

class Utils extends Api
{
    /**
     * @var string
     */
    static $prefixTag = 'utils';

    /**
     * @param string $placeId
     * @return object[]
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAddressDetails($placeId)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_address_details_get', null, [$placeId]);
    }

    /**
     * @param string $address
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function postAddress($address)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_address_post', ["address" => $address]);
    }
}
