<?php

namespace Catalizr\Lib;

/**
 * Description of Config
 *
 * @author codati
 */
class Config {
   public $publicKey;
   public $privateKey;
   public $url = "https://qualif.api.catalizr.io/v1";
   
   public $folderCache = __DIR__. DIRECTORY_SEPARATOR ."..".DIRECTORY_SEPARATOR. "cache";
   public function __construct($config) {
        if(isset($config['privateKey']))
        {
          $this->privateKey = $config['privateKey'];
        }
        if(isset($config['publicKey']))
        {
          $this->publicKey = $config['publicKey'];

        }
        if(isset($config['url']))
        {
          $this->url = $config['url'];
        }
        if(isset($config['folderCache']))
        {
          $this->folderCache = $config['folderCache'];
        }
   }
}
