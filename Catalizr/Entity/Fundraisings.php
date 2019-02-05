<?php

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

/**
 * Description of Fundraisings
 *
 * @author codati
 */
class Fundraisings extends \Catalizr\Lib\Entity {

    use Timestampable;

    const FUNDS_TYPE_CREATE = 'CREATE';
    const FUNDS_TYPE_UPGRADE = 'UPGRADE';

    const PART_TYPE_ACTION_INVEST = 'ACTION_INVEST';
    const PART_TYPE_CERT_INVEST = 'CERT_INVEST';

    const PART_NATURE_PARTS_SOCIALES = 'PARTS_SOCIALES';
    const PART_NATURE_TITRES_ETRANGERS = 'TITRES_ETRANGERS';

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'amount_total',
    ];

    static $hiddenProperties = [
        'sql_id',
        'entity',
        'issuer_id',
    ];

    /**
     * @var float
     */
    public $amount_total;

    /**
     * @var int
     */
    public $close_date;

    /**
     * @var string
     */
    public $company;

    /**
     * @var bool
     */
    public $default;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $documents;

    /**
     * @var string
     */
    public $end_date;

    /**
     * @var float
     */
    public $fee;

    /**
     * @var string
     */
    public $funds_type;

    /**
     * @var array
     */
    public $history;

    /**
     * @var float
     */
    public $minimum_investment;

    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $part_amount;

    /**
     * @var string
     */
    public $part_nature;

    /**
     * @var string
     */
    public $part_type;

    /**
     * @var string
     */
    public $start_date;

    /**
     * @var string
     */
    public $status;
}
