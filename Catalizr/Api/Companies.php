<?php

namespace Catalizr\Api;

/**
 * Description of Companies
 *
 * @author codati
 */
class Companies extends \Catalizr\Lib\Api{
    static $classEntity = '\Catalizr\Entity\Companies';
    static $prefixTag = 'companies';
    
    
    /**
     * 
     * @param string $prefixTag
     * @param string|int|double $iid external iid
     * @return string
     */
    public function getIdByExternalIid($iid) {

        return parent::getIdByExternalIid( self::$prefixTag, $iid);
    }
    
    /**
     * 
     * @param string $id id of catalizr
     * @return \Catalizr\Entity\Companies Company get
     */
    public function getById($id) {
        return parent::getById( self::$prefixTag, self::$classEntity, $id);
    }
    
   /**
    * 
    * @return string[]
    */
    public function getAllId() {
        return parent::getAll(self::$prefixTag, self::$classEntity);
    }
    
    /**
     * 
     * @param string|int|double $iid external id
     * @return \Catalizr\Entity\Companies Company get
     */
    public function getByExternalId($iid) {
        return parent::getByExternalId(self::$prefixTag, $iid);
    }
    /**
     * 
     * @param \Catalizr\Entity\Companies Company investor for save
     * @return void
     */
    public function create(\Catalizr\Entity\Companies &$Company) {
        parent::create(self::$prefixTag, $Company);
    }
    /**
     * 
     * @param string $id
     * @param \Catalizr\Entity\Fundraisings $fundraising
     */
    public function createFundraisingsByCompanyId($id ,\Catalizr\Entity\Fundraisings &$fundraising){
        
        if(isset($fundraising->iid)){
            $fundraising->iid =(string) $fundraising->iid;
        }
        
        $object = $this->api->helperRequest->executeReq(self::$prefixTag.'_postFundraisings', $fundraising,[$id]);
        if(isset($object->iid)){
            $fundraising->iid = $object->iid;        
        }
        $fundraising->id = $object->id;
        
    }
    /**
     * 
     * @param \Catalizr\Entity\Companies $Company
     * @param \Catalizr\Entity\Fundraisings $fundraising
     */
    public function createFundraisingsByCompany(\Catalizr\Entity\Companies $Company ,\Catalizr\Entity\Fundraisings &$fundraising){
        $this->createFundraisingsById($Company->id,$fundraising);
    }
    /**
     * 
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Fundraisings $fundraising
     */
    public function createFundraisingsByExternalCompanyId($iid ,\Catalizr\Entity\Fundraisings &$fundraising){
        $id=$this->getIdByExternalIid($iid);
        
        $this->createFundraisingsById($id,$fundraising);
        
    }

    
    /**
     * 
     * @param string $id
     * @param \Catalizr\Entity\Documents $document
     */
    public function createDocumentByCompanyId($id, \Catalizr\Entity\Documents &$document){
        $this->createDocumentById(self::$prefixTag,$id, $document);
    }
    /**
     * 
     * @param \Catalizr\Entity\Companies $Company
     * @param \Catalizr\Entity\Documents $document
     */
    public function createDocumentByCompany(\Catalizr\Entity\Companies $Company ,\Catalizr\Entity\Documents &$document){
        $this->createDocumentById(self::$prefixTag,$Company->id, $document);

    }
    /**
     * 
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Documents $document
     */
    public function createDocumentByExternalCompanyId($iid ,\Catalizr\Entity\Documents &$document){
        $id=$this->getIdByExternalIid(self::$prefixTag, $iid);
        
        $this->createDocumentById(self::$prefixTag,$id,$document);
    }
    
    
    
    /**
     * 
     * @param string $id
     * @param \Catalizr\Entity\Fundraisings $fundraising
     */
    public function getFundraisingsIdByCompanyId($id) {
                    
        return $this->api->helperRequest->executeReq(self::$prefixTag.'_getFundraisings', null,[$id]);
        
    }
    /**
     * 
     * @param \Catalizr\Entity\Companies $Company
     * @param \Catalizr\Entity\Fundraisings $fundraising
     */
    public function getFundraisingsIdByCompnay(\Catalizr\Entity\Companies $Company){
        return $this->getFundraisingsIdByCompanyId($Company->id);
    }
    /**
     * 
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Fundraisings $fundraising
     */             
    public function getFundraisingsIdByExternalCompanyId($iid){
        $id = $this->getIdByExternalIid($iid);
        var_dump($id);
        return $this->getFundraisingsIdByCompanyId($id);
        
    }
    
    
}
