<?php


namespace Catalizr\Entity;

/**
 * Description of Fundraisings
 *
 * @author codati
 */
class Fundraisings extends \Catalizr\Lib\Entity {
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
    public $name;
    /**
     *
     * @var float
     */
    public $part_amount;
    /**
     *
     * @var float
     */
    public $minimum_investment;
    /**
     *
     * @var float
     */
    public $fee;
    /**
     *
     * @var string
     */
    public $description;
    /**
     *
     * @var float
     */
    public $amount_total;
    /**
     *
     * @var string
     */
    public $start_date;
    /**
     *
     * @var string
     */
    public $end_date;
    /**
     *
     * @var string
     */
    public $funds_type;
    /**
     *
     * @var string
     */
    public $part_nature;
    /**
     *
     * @var string
     */
    public $part_type;
    /**
     *
     * @var string
     */
    public $company;
    /**
     *
     * @var array
     */
    public $history;
    /**
     *
     * @var array
     */
    public $documents;
}
