<?php

namespace Catalizr\Api;
use Catalizr\Pagination;

/**
 * Description of ApiInverstor
 *
 * @author codati
 */
class Investors extends \Catalizr\Lib\Api
{
    /**
     * @var string
     */
    static $classEntity =  "\Catalizr\Entity\Investors";

    /**
     * @var string
     */
    static $prefixTag =  'investors';


    /**
     * @param \Catalizr\Entity\Investors $investor investor to save
     * @return void
     * @throws \Catalizr\Lib\HttpException
     */
    public function create(\Catalizr\Entity\Investors &$investor)
    {
        parent::create(self::$prefixTag, $investor);
    }

    /**
     * @param Pagination|null $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllId(Pagination $pagination = null)
    {
        return parent::getAll(self::$prefixTag, $pagination);
    }

    /**
     * @param \Catalizr\Entity\Investors $investors
     * @param \Catalizr\Pagination|null $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllInvestmentsIds(\Catalizr\Entity\Investors $investors, Pagination $pagination = null)
    {
        return parent::getAllById(self::$prefixTag . '_investments', $investors->id, $pagination);
    }

    /**
     * @param $email
     * @return \Catalizr\Entity\Investors
     * @throws \Catalizr\Lib\HttpException
     */
    public function getByEmail($email)
    {
        $objectInvestor = $this->api->helperRequest->executeReq(self::$prefixTag . '_getByEmail', null , [$email]);
        return new self::$classEntity($objectInvestor);
    }

    /**
     * @param string|int|double $iid external id
     * @return \Catalizr\Entity\Investors
     * @throws \Catalizr\Lib\HttpException
     */
    public function getByExternalId($iid)
    {
        return parent::getByExternalId($iid);
    }

    /**
     * @param string $id id of catalizr
     * @return \Catalizr\Entity\Investors
     * @throws \Catalizr\Lib\HttpException
     */
    public function getById($id)
    {
        return parent::getById( self::$prefixTag, self::$classEntity, $id);
    }

    /**
     * @param string|int|double $iid external iid
     * @return string
     * @throws \Catalizr\Lib\HttpException
     */
    public function getIdByExternalIid($iid)
    {
        return parent::getIdByExternalIid( self::$prefixTag, $iid);
    }

    /**
     * @param \Catalizr\Entity\Investors $investor
     * @return \Catalizr\Entity\Investors
     * @throws \Catalizr\Lib\HttpException
     */
    public function update(\Catalizr\Entity\Investors $investor)
    {
        parent::update(self::$prefixTag, $investor);
    }
}
