<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 20/06/18
 * Time: 17:14
 */

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

class InvestmentLink extends \Catalizr\Lib\Entity
{
    use Timestampable;

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'url',
    ];

    /**
     * @var array
     */
    public $documents;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $investment_id;

    /**
     * @var string
     */
    public $investment_support;

    /**
     * @var int
     */
    public $open_date;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $url;
}
