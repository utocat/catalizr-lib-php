<?php


namespace Catalizr\Api;

/**
 * Description of Documents
 *
 * @author codati
 */
class Documents extends \Catalizr\Lib\Api{
    static $prefixTag = 'documents';

    /**
     * 
     * @param string $id
     * @return string
     */    
    public function getDocumentToBinaryByIdDocument($id) {
        return $this->api->helperRequest->executeReq(self::$prefixTag . "_get", null, [$id]);
    }
    /**
     * 
     * @param string $id
     * @param string $path
     * @return string pathToFile
     */
    public function getDocumentToPathFolderByIdDocument($id,$path) {
        $fileSet = false;
        $fileNameReturn = "";
        $opt = array(
            CURLOPT_HEADERFUNCTION => function($curl,$header) use ($path,&$fileSet,&$fileNameReturn) {
                $headerExplode = explode(':', $header, 2);
                if($header === "\r\n" && !$fileSet){
                    curl_setopt($curl, CURLOPT_FILE, fopen($path.time(),"w+"));
                    $fileNameReturn = $path.time();
                }
                if($headerExplode[0] === 'Content-Disposition'){
                   $fileName = explode( '"',$headerExplode[1])[1];
                   var_dump($fileName);
                   $fileSet= true;
                   curl_setopt($curl, CURLOPT_FILE, fopen($path.$fileName,"w+"));
                   $fileNameReturn =$path.$fileName;

                }
               return strlen($header);
           });
        $this->api->helperRequest->executeReq(self::$prefixTag . "_get", null, [$id], null, $opt );
        return $fileNameReturn;
    }
    /**
     * 
     * @param string $id
     */
    public function getDocumentToStdOutByIdDocument($id) {
        ini_set('display_errors',false); 

        $opt = array(
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_HEADERFUNCTION => function($curl,$header){
               $headerExplode = explode(':', $header, 2);
               if(in_array($headerExplode[0], array('Content-Type','Content-Disposition','Content-Length')))
               {
                   header($header);
               }
               
               return  strlen($header);
           });

        $this->api->helperRequest->executeReq(self::$prefixTag . "_get", null, [$id], null, $opt );
    }
}
