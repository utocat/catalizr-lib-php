<?php

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

/**
 * Description of Banks
 *
 * @author codati
 */
class Banks extends \Catalizr\Lib\Entity {

    use Timestampable;

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'createdAt',
        'updatedAt'
    ];

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $logo;
    
    // remove in the future version =>
    /**
     * @var array
     */
    public $authorized_domain_email_address;

    /**
     * @var string
     */
    public $subdomain;
         
    /**
     * @var boolean
     */   
    public $permit_all_domain_email_address;
    // <=
    
}
