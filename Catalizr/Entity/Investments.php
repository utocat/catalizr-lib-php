<?php

namespace Catalizr\Entity;

/**
 * Description of Investments
 *
 * @author codati
 */
class Investments extends \Catalizr\Lib\Entity {
    /**
     *
     * @var int
     */
    public $updatedAt;
    /**
     *
     * @var int
     */
    public $createdAt;
    /**
     *
     * @var string
     */
    public $investor_id;
    /**
     *
     * @var string
     */
    public $fundraising_id;
    
    /**
     *
     * @var string|int|double
     */
    public $investor_external_id;
    /**
     *
     * @var string|int|double
     */
    public $fundraising_external_id;
    
    /**
     *
     * @var \Catalizr\Entity\Investors
     */
    public $investor;
    /**
     *
     * @var \Catalizr\Entity\Fundraisings
     */
    public $fundraising;
    
    
    /**
     *
     * @var string
     */
    public $payment_mode;
    /**
     *
     * @var int
     */
    public $nb_part;
    /**
     *
     * @var string
     */
    public $iban;
    /**
     *
     * @var string
     */
    public $bic_swift;
    /**
     *
     * @var string
     */
    public $bank_name;
    /**
     *
     * @var string
     */
    
    public $bank_address;

    
    /**
     *
     * @var string
     */    
    public $status;

    /**
     *
     * @var string[]
     */
    public $documents;
    
    /**
     * 
     * @return object
     */
    public function jsonSerialize() {
      //  $array = (array) $this;
        $arrayResult = array();
        
        $keyNotAllowed = array('investor', 'investor_external_id','fundraising','fundraising_external_id');
        
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
