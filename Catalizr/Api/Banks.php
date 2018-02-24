<?php

namespace Catalizr\Api;

/**
 * Description of ApiBanks
 *
 * @author codati
 */
class Banks extends \Catalizr\Lib\Api{
        
    static $classEntity =  '\Catalizr\Entity\Banks';
    static $prefixTag =  'banks';
    /**
     * 
     * @return \Catalizr\Entity\Banks[]
     */
    public function getAll() {
       $objects= parent::getAll(self::$prefixTag, self::$classEntity);
       $className = self::$classEntity;
        return $className::hydrateAll($objects);
    }
}
