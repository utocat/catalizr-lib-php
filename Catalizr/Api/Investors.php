<?php

namespace Catalizr\Api;

/**
 * Description of ApiInverstor
 *
 * @author codati
 */
class Investors extends \Catalizr\Lib\Api{
    /**
     *
     * @var string
     */
    static $classEntity =  "\Catalizr\Entity\Investors";
    /**
     *
     * @var string
     */
    static $prefixTag =  'investors';

    /**
     * 
     * @param string $id id of catalizr
     * @return \Catalizr\Entity\Investors Investor get
     */
    public function getById($id) {
        return parent::getById( self::$prefixTag, self::$classEntity, $id);
    }
    
   /**
    * 
    * @return string[]
    */
    public function getAllid() {
        return parent::getAll(self::$prefixTag, self::$classEntity);
    }
    
    /**
     * 
     * @param string|int|double $iid external id
     * @return \Catalizr\Entity\Investors Investor get
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
     * @param \Catalizr\Entity\Investors $investor investor for save
     * @return void
     */
    public function create(\Catalizr\Entity\Investors &$investor) {
        parent::create(self::$prefixTag, $investor);
    }
}
