<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 14/06/18
 * Time: 09:33
 */

namespace Catalizr\Api;


class Reports extends \Catalizr\Lib\Api
{
    /**
     * @var string
     */
    static $classEntity = '\Catalizr\Entity\ReportTemplate';

    /**
     * @var string
     */
    static $prefixTag = 'reports';


    /**
     * @param string $id
     * @return \Catalizr\Entity\ReportTemplate
     * @throws \Catalizr\Lib\HttpException
     */
    public function getById($id)
    {
        return parent::getById(self::$prefixTag, self::$classEntity, $id);
    }

    /**
     * @param string $code
     * @return \Catalizr\Entity\ReportTemplate
     * @throws \Catalizr\Lib\HttpException
     */
    public function getByCode($code)
    {
        $object = $this->api->helperRequest->executeReq(self::$prefixTag . '_codes_get', null, [$code]);

        return new self::$classEntity($object);
    }
}
