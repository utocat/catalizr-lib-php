<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Catalizr\Lib;

/**
 * Description of HttpException
 *
 * @author codati
 */
class HttpException extends \Exception{
    
    
    
    public function __construct( $body , $code,$previous= null) {
        
        $bodyDecode = json_decode($body);
        if(isset($bodyDecode->message) )
        {
            if(is_string($bodyDecode->message))
            {
                $message = $bodyDecode->message;
            }else{
                $message = json_encode($bodyDecode->message);
            }
        }else{
            $message = "body => ". $body.", codeHttp => " .$code;

        }
        
        parent::__construct($message, $code, $previous);
    }
}
