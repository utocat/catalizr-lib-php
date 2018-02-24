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
    public $siret;    
        
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
    
}
