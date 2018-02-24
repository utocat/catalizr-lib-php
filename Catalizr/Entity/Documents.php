<?php


namespace Catalizr\Entity;

/**
 * Description of Banks
 *
 * @author codati
 */
class Documents extends \Catalizr\Lib\Entity {
    /**
     *
     * @var string
     */
    public $type_mime;
    
    /**
     *
     * @var string
     */
    public $type;
    
    /**
     *
     * @var bool
     */
    public $signed;
    
    /**
     *
     * @var string
     */
    public $path_to_file;
    
    /**
     * 
     * @return object
     */
    public function jsonSerialize() {
      //  $array = (array) $this;
        $arrayResult = array();
        
        $keyNotAllowed = array('path_to_file');
        
        foreach ($this as $key => $value) {
            if(in_array($key,$keyNotAllowed) )
            {
                continue;
            }
            if(isset($value))
            {
                $arrayResult[$key] = $value;
            }
        }
        return $arrayResult;
     }
}
