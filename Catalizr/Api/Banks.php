<?php

namespace Catalizr\Api;

/**
 * Description of ApiBanks
 *
 * @author codati
 */
class Banks extends \Catalizr\Lib\Api{

    /**
     * @var string
     */
    static $classEntity =  '\Catalizr\Entity\Banks';

    /**
     * @var string
     */
    static $prefixTag =  'banks';


    /**
     * TODO: maybe add pagination (need to be added in API too)
     * @return \Catalizr\Entity\Banks[]
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAll()
    {
       $objects = parent::getAll(self::$prefixTag);
       $className = self::$classEntity;
       return $className::hydrateAll($objects);
    }
}
