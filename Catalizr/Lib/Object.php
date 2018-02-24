<?php

namespace Catalizr\Lib;

/**
 * Description of Api
 *
 * @author codati
 */
class Object {
    /**
     *
     * @var \Catalizr\Api
     */
    protected $api ;
    
    public function __construct(\Catalizr\Api $api) {
        $this->api = $api;
    }
}
