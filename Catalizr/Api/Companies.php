<?php

namespace Catalizr\Api;

use Catalizr\Pagination;

/**
 * Description of Companies
 *
 * @author codati
 */
class Companies extends \Catalizr\Lib\Api
{

    /**
     * @var string
     */
    static $classEntity = '\Catalizr\Entity\Companies';

    /**
     * @var string
     */
    static $prefixTag = 'companies';


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
     * @param string $id
     * @return \Catalizr\Entity\Companies
     * @throws \Catalizr\Lib\HttpException
     */
    public function getById($id)
    {
        return parent::getById(self::$prefixTag, self::$classEntity, $id);
    }

    /**
     * @param string $siren
     * @return \Catalizr\Entity\Companies
     * @throws \Catalizr\Lib\HttpException
     */
    public function getBySiren($siren)
    {
        $companyObject = $this->api->helperRequest->executeReq(self::$prefixTag . '_getBySiren', null, [$siren]);

        return new self::$classEntity($companyObject);
    }

   /**
    * @param Pagination $pagination
    * @return string[]
    * @throws \Catalizr\Lib\HttpException
    */
    public function getAllIds(Pagination $pagination)
    {
        return parent::getAll(self::$prefixTag, $pagination);
    }

    /**
     * @param string $iid external id
     * @return \Catalizr\Entity\Companies
     * @throws \Catalizr\Lib\HttpException
     */
    public function getByExternalId($iid)
    {
        return parent::getByExternalId($iid);
    }

    /**
     * @param \Catalizr\Entity\Companies Company investor to save
     * @return void
     * @throws \Catalizr\Lib\HttpException
     */
    public function create(\Catalizr\Entity\Companies &$Company)
    {
        parent::create(self::$prefixTag, $Company);
    }

    /**
     * @param string $id
     * @param \Catalizr\Entity\Fundraisings $fundraising
     * @return void
     * @throws \Catalizr\Lib\HttpException
     */
    public function createFundraisingsByCompanyId($id, \Catalizr\Entity\Fundraisings &$fundraising)
    {
        if (isset($fundraising->iid)) {
            $fundraising->iid =(string) $fundraising->iid;
        }

        $object = $this->api->helperRequest->executeReq(self::$prefixTag.'_postFundraisings', $fundraising, [$id]);

        if (isset($object->iid)) {
            $fundraising->iid = $object->iid;
        }
        $fundraising->id = $object->id;
    }

    /**
     * @param \Catalizr\Entity\Companies $Company
     * @param \Catalizr\Entity\Fundraisings $fundraising
     * @return void
     * @throws \Catalizr\Lib\HttpException
     */
    public function createFundraisingsByCompany(\Catalizr\Entity\Companies $Company, \Catalizr\Entity\Fundraisings &$fundraising)
    {
        $this->createFundraisingsByCompanyId($Company->id,$fundraising);
    }

    /**
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Fundraisings $fundraising
     * @throws \Catalizr\Lib\HttpException
     */
    public function createFundraisingsByExternalCompanyId($iid, \Catalizr\Entity\Fundraisings &$fundraising)
    {
        $id = $this->getIdByExternalIid($iid);
        $this->createFundraisingsByCompanyId($id,$fundraising);
    }

    /**
     * @param string $id
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByCompanyId($id, \Catalizr\Entity\Documents &$document)
    {
        $this->createDocumentById(self::$prefixTag, $id, $document);
    }

    /**
     * @param \Catalizr\Entity\Companies $Company
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByCompany(\Catalizr\Entity\Companies $Company, \Catalizr\Entity\Documents &$document)
    {
        $this->createDocumentById(self::$prefixTag, $Company->id, $document);
    }

    /**
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByExternalCompanyId($iid, \Catalizr\Entity\Documents &$document)
    {
        $id = $this->getIdByExternalIid($iid);
        $this->createDocumentById(self::$prefixTag, $id,$document);
    }

    /**
     * @param string $id
     * @return string
     * @throws \Catalizr\Lib\HttpException
     */
    public function getFundraisingsIdByCompanyId($id)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag.'_getFundraisings', null, [$id]);
    }

    /**
     * @param \Catalizr\Entity\Companies $Company
     * @return string
     * @throws \Catalizr\Lib\HttpException
     */
    public function getFundraisingsIdByCompany(\Catalizr\Entity\Companies $Company)
    {
        return $this->getFundraisingsIdByCompanyId($Company->id);
    }

    /**
     * @param string|int|double $iid
     * @return string
     * @throws \Catalizr\Lib\HttpException
     */
    public function getFundraisingsIdByExternalCompanyId($iid){
        $id = $this->getIdByExternalIid($iid);
        return $this->getFundraisingsIdByCompanyId($id);
    }

    /**
     * @param string $search
     * @return object[]
     * @throws \Catalizr\Lib\HttpException
     */
    public function searchByName($search)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_search', ['query' => $search]);
    }

    /**
     * @param \Catalizr\Entity\Companies $company
     * @return \Catalizr\Lib\Entity
     * @throws \Catalizr\Lib\HttpException
     */
    public function update(\Catalizr\Entity\Companies $company)
    {
        return parent::update(self::$prefixTag, $company);
    }
}
