<?php

namespace Catalizr\Entity;

/**
 * Description of Investors
 *
 * @author codati
 */
class Investors extends \Catalizr\Lib\Entity {
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
    public $title;
    /**
     *
     * @var string
     */
    public $name;
    /**
     *
     * @var string
     */
    public $surname;
    /**
     *
     * @var string
     */
    public $birth_date;
    /**
     *
     * @var string
     */
    public $birth_city;
    
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
}
