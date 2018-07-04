<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 25/06/18
 * Time: 16:49
 */

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

class SignatureLink extends \Catalizr\Lib\Entity
{
    use Timestampable;

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'createdAt',
        'updatedAt',
    ];

    /**
     * @var array
     */
    public $documents;

    /**
     * @var string
     */
    public $docuSign_id;

    /**
     * @var string
     */
    public $docuSign_url;

    /**
     * @var string
     */
    public $url;

    /**
     * @var object
     */
    public $user;
}
