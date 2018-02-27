<?php

namespace Catalizr\Lib;

/**
 * Description of HelperRequest
 *
 * @author codati
 */
class HelperRequest extends Object{
    /**
     *
     * @var string
     */
    private $jwt;
    
    private $listTag= array(
    'banks_getAll' =>array( 'url' => '/banks', 'methode' => RequestType::GET, 'expectedCode' => array(200)),  
    'authentification' =>array( 'url' => '/authorize', 'methode' => RequestType::POST, 'expectedCode' => array(200)),
    'investors_get' =>array( 'url' => '/investors/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'investors_getAll' =>array( 'url' => '/investors', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'investors_getiid' =>array( 'url' => '/investors/iid/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'investors_post' =>array( 'url' => '/investors', 'methode' => RequestType::POST, 'expectedCode' => array(201)),
    'companies_get' =>array( 'url' => '/companies/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'companies_getiid' =>array( 'url' => '/companies/iid/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'companies_getAll' =>array( 'url' => '/companies', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'companies_post' =>array( 'url' => '/companies', 'methode' => RequestType::POST, 'expectedCode' => array(201)),
    'companies_postFundraisings' =>array( 'url' => '/companies/%s/fundraisings', 'methode' => RequestType::POST,'expectedCode' => array(201)),
    'companies_getFundraisings' =>array( 'url' => '/companies/%s/fundraisings', 'methode' => RequestType::GET,'expectedCode' => array(200)),
    'companies_postDocuments' =>array( 'url' => '/companies/%s/documents', 'methode' => RequestType::POST,'expectedCode' => array(201)),
    'fundraisings_get' =>array( 'url' => '/fundraisings/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'fundraisings_getiid' =>array( 'url' => '/fundraisings/iid/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'fundraisings_close' =>array( 'url' => '/fundraisings/%s/close', 'methode' => RequestType::POST, 'expectedCode' => array(200)),
    'fundraisings_postDocuments' =>array( 'url' => '/fundraisings/%s/documents', 'methode' => RequestType::POST, 'expectedCode' => array(201)),
    'investments_get' =>array( 'url' => '/investments/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
//    'investments_getAll' =>array( 'url' => '/investments', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'investments_getiid' =>array( 'url' => '/investments/iid/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200)),
    'investments_post' =>array( 'url' => '/investments', 'methode' => RequestType::POST, 'expectedCode' => array(201)),
    'investments_finish' =>array( 'url' => '/investments/%s/finish', 'methode' => RequestType::POST, 'expectedCode' => array(200)),
    'investments_postDocuments' =>array( 'url' => '/investments/%s/documents', 'methode' => RequestType::POST,'expectedCode' => array(201)),
    'documents_get' =>array( 'url' => '/documents/%s', 'methode' => RequestType::GET, 'expectedCode' => array(200))
    );
    
    private function getJwt($force = false){
        $pathJWT = $this->api->config->folderCache . DIRECTORY_SEPARATOR .'jwt.txt';

        if(!$force)
        {
            if(isset($this->jwt) ) {
                return $this->jwt;
            }
            
            if(file_exists($pathJWT)) {
                $this->jwt = file_get_contents($pathJWT);
                return $this->jwt;

            }
        }
        if(! file_exists( $this->api->config->folderCache))
        {
            mkdir($this->api->config->folderCache, 0700, true);
        }
        $responce = $this->executeReq('authentification',array('apiPublicKey' => $this->api->config->publicKey ) );
        $this->jwt = $responce->authorizationToken;
        file_put_contents($pathJWT,$this->jwt);

        return $this->jwt;
    }

    public function executeReq($tag, $data=null, $dataUrl=null, $params=null,$optionCurl=array(),$retry=true) {
        
        if($dataUrl)
        {
            $url = $this->api->config->url . sprintf( $this->listTag[$tag]['url'], ...$dataUrl);
            
        }else{
            $url = $this->api->config->url . $this->listTag[$tag]['url'];

        }
        $header = array();
        
        $curl = curl_init($url);

        if($data)
        {
            $header[]= 'Content-Type: application/json';
            $json = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$json);

        }else{
            $json= '';

        }

        if($tag !== 'authentification'){
           $header[] = 'authorization: a '.$this->getJwt(); 
        }
        $nonce = round(microtime(true) * 1000);
        
        $hmac = hash_hmac('sha512',$nonce . $url . $json, $this->api->config->privateKey);
        
        $header[]= "x-api-signature: $hmac";
        $header[]= "x-api-nonce: $nonce";
        
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->listTag[$tag]['methode']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
   
        curl_setopt_array($curl,$optionCurl);
        $responce = curl_exec($curl) ;
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

//        var_dump($responce);
//        var_dump($url);
        
//        // to delete when the API will fix <-- 
//        $responceDecode = json_decode($responce);
//        if($responceDecode->message === 'invalid token'){
//            $httpcode=401;
//        }
//        //-->
        
        if(in_array($httpcode, $this->listTag[$tag]['expectedCode'])){
            $responceDecode = json_decode($responce);
            if($responceDecode)
            {
                return $responceDecode;

            }else{
                return $responce;
            }
        }else{
            
            if($httpcode === 401 && $retry && $tag !== 'authentification')
            {
                $this->getJwt(true);
                $this->executeReq($tag, $data, $dataUrl, $params, $optionCurl, false);
            } else {
                throw new HttpException($responce,$httpcode);
         
            }
        }
    }
    
    public function executeUpload($file,$url ,$type_mime,$retry=true) {
        
        $header = array();
        
        $header[]= 'Content-Type: '.$type_mime;
        

        $nonce = round(microtime(true) * 1000);

        stream_wrapper_register("catalizr", "\Catalizr\Lib\CatalizrSteam");
        $urlCatalizr= "catalizr://concat/$file?&data=".$nonce . $url;
        $hmac = hash_hmac_file('sha512',$urlCatalizr , $this->api->config->privateKey);
        stream_wrapper_unregister('catalizr');
        $header[]= "x-api-signature: $hmac";
        $header[]= "x-api-nonce: $nonce";
        $header[]= 'authorization: a '.$this->getJwt(); 

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_INFILE, fopen($file, "rb"));
        curl_setopt($curl, CURLOPT_INFILESIZE, filesize($file));
        curl_setopt($curl, CURLOPT_PUT, true);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10000);

        $responce = curl_exec($curl) ;
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

//        var_dump($responce);
        
        // to delete when the API will fix <-- 
        $responceDecode = json_decode($responce);

        if($responceDecode->message === 'invalid token'){
            $httpcode=401;
        }
        //-->
        
        if($httpcode=== 201){
            $responceDecode = json_decode($responce);
            if($responceDecode)
            {
                return $responceDecode;

            }else{
                return $responce;
            }
        }else{
            
            if($httpcode === 401 && $retry)
            {
                $this->getJwt(true);
                $this->executeUpload($file, $url, $type_mime,false);
            } else {
                throw new HttpException($responce,$httpcode);
         
            }
        }
    }
}
