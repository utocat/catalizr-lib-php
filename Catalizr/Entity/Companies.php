<?php

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

/**
 * Description of Companies
 *
 * @author codati
 */
class Companies extends \Catalizr\Lib\Entity
{
    use Timestampable;

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'createdAt',
        'updatedAt',
        'documents',
        'fundraising_default'
    ];

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $bank_name;

    /**
     * @var string
     */
    public $bank_address;

    /**
     * @var string
     */
    public $bic_swift;

    /**
     * @var string
     */
    public $boss_name;

    /**
     * @var string
     */
    public $boss_phone;

    /**
     * @var string
     */
    public $boss_status;

    /**
     * @var string
     */
    public $boss_surname;

    /**
     * @var string
     */
    public $boss_title;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $country;

    /**
     * @var array
     */
    public $documents;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $fundraising_default;

    /**
     * @var string
     */
    public $iban;

    /**
     * @var bool
     */
    public $in_progress;

    /**
     * @var string
     */
    public $legal_form;

    /**
     * @var string
     */
    public $mobile_for_signature;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $siren;

    /**
     * @var string
     */
    public $zip;
}
