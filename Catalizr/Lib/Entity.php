<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Catalizr\Lib;

/**
 * Description of Entity
 *
 * @author codati
 */
class Entity implements \JsonSerializable {

    static $notAllowedProperties = [
        'id',
        'iid',
    ];

    /**
     *
     * @var string
     */
    public $id;

    /**
     *
     * @var string|int|double
     */
    public $iid;

    public function __set ($name, $value){
        $className = get_class($this);
        throw new \Exception("$name in $className not exist");
    }

    static public function hydrateAll($object) {
        $result = array();
        foreach ($object as  $value) {
            $class = get_called_class();
            $result[] = new $class($value);
        }
        return $result;
    }

    public function __construct( $object=array()) {
        foreach ($object as $key => $value) {

            $this->$key = $value;
        }
    }
    /**
     *
     * @return object
     */
    public function jsonSerialize() {
        $arrayResult = array();

        foreach ($this as $key => $value) {
            if(isset($value))
            {
                $arrayResult[$key] = $value;
            }
        }
        return $arrayResult;
     }

}
