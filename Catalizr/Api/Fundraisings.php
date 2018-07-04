<?php

namespace Catalizr\Api;
use Catalizr\Pagination;

/**
 * Description of ApiInverstor
 *
 * @author codati
 */
class Fundraisings extends \Catalizr\Lib\Api
{
    /**
     * @var string
     */
    static $classEntity =  "\Catalizr\Entity\Fundraisings";

    /**
     * @var string
     */
    static $prefixTag =  'fundraisings';


    /**
     * @param string|int|double $iid external id
     * @throws \Catalizr\Lib\HttpException
     */
    public function closeByExternalFundraisingId($iid)
    {
        $id = $this->getIdByExternalIid($iid);
        $this->closeByIdFundraising($id);
    }

    /**
     * @param \Catalizr\Entity\Fundraisings
     * @throws \Catalizr\Lib\HttpException
     */
    public function closeByFundraising($fundraisings)
    {
        $this->closeByIdFundraising($fundraisings->id);
    }

    /**
     * @param string $id id of catalizr
     * @throws \Catalizr\Lib\HttpException
     */
    public function closeByIdFundraising($id)
    {
        $this->api->helperRequest->executeReq(self::$prefixTag.'_close', null, [$id]);
    }

    /**
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByExternalFundraisingId($iid, \Catalizr\Entity\Documents &$document)
    {
        $id = $this->getIdByExternalIid( $iid);
        $this->createDocumentById(self::$prefixTag, $id,$document);
    }

    /**
     * @param \Catalizr\Entity\Fundraisings $Fundraising
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByFundraising(\Catalizr\Entity\Fundraisings $Fundraising ,\Catalizr\Entity\Documents &$document)
    {
        $this->createDocumentById(self::$prefixTag, $Fundraising->id,$document);
    }

    /**
     * @param string $id
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByFundraisingId($id, \Catalizr\Entity\Documents &$document)
    {
        $this->createDocumentById(self::$prefixTag,$id, $document);
    }

    /**
     * @param \Catalizr\Entity\Fundraisings $fundraisings
     * @param Pagination|null $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllInvestmentsIds(\Catalizr\Entity\Fundraisings $fundraisings, Pagination $pagination = null)
    {
        return parent::getAllById(self::$prefixTag . '_investments', $fundraisings->id, $pagination);
    }

    /**
     * @param string|int|double $iid external id
     * @return \Catalizr\Entity\Fundraisings
     * @throws \Catalizr\Lib\HttpException
     */
    public function getByExternalId($iid)
    {
        return parent::getByExternalId($iid);
    }

    /**
     * @param string $id id of catalizr
     * @return \Catalizr\Entity\Fundraisings
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
     * @param \Catalizr\Entity\Fundraisings $fundraising
     * @return \Catalizr\Entity\Fundraisings
     * @throws \Catalizr\Lib\HttpException
     */
    public function update(\Catalizr\Entity\Fundraisings $fundraising)
    {
        return parent::update(self::$prefixTag, $fundraising);
    }
}
