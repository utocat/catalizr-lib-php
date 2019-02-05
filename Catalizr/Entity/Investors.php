<?php

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

/**
 * Description of Investors
 *
 * @author codati
 */
class Investors extends \Catalizr\Lib\Entity
{
    use Timestampable;

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'createdAt',
        'documents',
        'updatedAt',
    ];

    static $hiddenProperties = [
        'updatedAtDisplay',
        'sql_id',
        'entity',
        'ibans',
        'name_surname',
    ];

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $bic_swift;

    /**
     * @var string
     */
    public $birth_city;

    /**
     * @var string
     */
    public $birth_date;

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
    public $iban;

    /**
     * @var bool
     */
    public $modified;

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
    public $surname;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $zip;
}
