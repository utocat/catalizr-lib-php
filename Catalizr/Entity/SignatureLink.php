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
    public $url_docusign;
    
    /**
     * @var string
     */
    public $url;
}
