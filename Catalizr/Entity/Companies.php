<?php


namespace Catalizr\Entity;

/**
 * Description of Companies
 *
 * @author codati
 */
class Companies extends \Catalizr\Lib\Entity{
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
    public $legal_form;
    /**
     *
     * @var string
     */
    public $name;
    
    /**
     *
     * @var string
     */
    public $address;
    /**
     *
     * @var string
     */
    public $zip;
    
    /**
     *
     * @var string
     */
    public $city;
    
    /**
     *
     * @var string
     */
    public $country;
   
    /**
     *
     * @var string
     */
    public $email;
    
    /**
     *
     * @var array()
     */
    public $documents;
    
    /**
     *
     * @var string
     */
    public $siren;    
        
    /**
     *
     * @var string
     */
    public $phone;   
    /**
     *
     * @var bool
     */
    public $in_progress;  
    /**
     *
     * @var string
     */
    public $boss_title;
    /**
     *
     * @var string
     */
    public $boss_name;
    /**
     *
     * @var string
     */
    public $boss_surname;
    /**
     *
     * @var string
     */
    public $boss_phone;
    /**
     *
     * @var string
     */
    public $boss_status;
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
    
    public $fundraising_default;
    
}
