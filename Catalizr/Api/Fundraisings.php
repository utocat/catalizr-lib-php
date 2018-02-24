<?php

namespace Catalizr\Api;

/**
 * Description of ApiInverstor
 *
 * @author codati
 */
class Fundraisings extends \Catalizr\Lib\Api{
    /**
     *
     * @var string
     */
    static $classEntity =  "\Catalizr\Entity\Fundraisings";
    /**
     *
     * @var string
     */
    static $prefixTag =  'fundraisings';

    /**
     * 
     * @param string $id id of catalizr
     * @return \Catalizr\Entity\Fundraisings Fundraisings get
     */
    public function getById($id) {
        return parent::getById( self::$prefixTag, self::$classEntity, $id);
    }
    /**
     * 
     * @param string|int|double $iid external id
     * @return \Catalizr\Entity\Fundraisings Fundraisings get
     */
    public function getByExternalId($iid) {
        return parent::getByExternalId(self::$prefixTag, $iid);
    }
    
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
     * @return void
     */
    public function closeByIdFundraising($id) {
        return $this->api->helperRequest->executeReq(self::$prefixTag.'_close', null,[$id]);
    }
    /**
     * 
     * @param \Catalizr\Entity\Fundraisings
     * @return void
     */
    public function closeByFundraising($fundraisings) {
        return $this->closeByIdFundraising($fundraisings->id);
    }
    /**
     * 
     * @param string|int|double $iid external id
     * @return void
     */
    public function closeByExternalFundraisingId($iid) {
        $id = $this->getByExternalId( $iid);
        return $this->closeByIdFundraising($id);

    }
        /**
     * 
     * @param string $id
     * @param \Catalizr\Entity\Documents $document
     */
    public function createDocumentByFundraisingId($id, \Catalizr\Entity\Documents &$document){
        $this->createDocumentById(self::$prefixTag,$id, $document);
    }
    /**
     * 
     * @param \Catalizr\Entity\Fundraisings $Fundraising
     * @param \Catalizr\Entity\Documents $document
     */
    public function createDocumentByFundraising(\Catalizr\Entity\Fundraisings $Fundraising ,\Catalizr\Entity\Documents &$document){
        $this->createDocumentById(self::$prefixTag,$Fundraising->id, $document);

    }
    /**
     * 
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Documents $document
     */
    public function createDocumentByExternalFundraisingId($iid ,\Catalizr\Entity\Documents &$document){
        $id=$this->getIdByExternalIid( $iid);
        
        $this->createDocumentById(self::$prefixTag,$id,$document);
    }
    
    
}
