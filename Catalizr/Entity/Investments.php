<?php

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

/**
 * Description of Investments
 *
 * @author codati
 */
class Investments extends \Catalizr\Lib\Entity
{
    use Timestampable;

    const STATUS_WAITING_DOCUMENT = 'WAITING_DOCUMENT';
    const STATUS_NEW = 'NEW';
    const STATUS_BANK_RECEIVED = 'BANK_RECEIVED';
    const STATUS_BANK_CONFIRMED = 'BANK_CONFIRMED';
    const STATUS_EXPIRED = 'EXPIRED';
    const STATUS_REPORTED = 'REPORTED';

    const PAYMENT_MODE_PEA = 'PEA';
    const PAYMENT_MODE_PEA_PME = 'PEA-PME';
    const PAYMENT_MODE_PEE = 'PEE';
    const PAYMENT_MODE_COMPTE_TITRE = 'Compte titre ordinaireEA';
    const PAYMENT_MODE_CB = 'CB';
    const PAYMENT_MODE_SEPA = 'SEPA';

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'investor',
        'investor_external_id',
        'fundraising',
        'fundraising_external_id',
    ];


    /**
     * @var string
     */
    public $bank_address;

    /**
     * @var string
     */
    public $bank_name;

    /**
     * @var string
     */
    public $bic_swift;

    /**
     * @var string
     */
    public $category;

    /**
     * @var int
     */
    public $close_date;

    /**
     * @var \Catalizr\Entity\Companies
     */
    public $company;

    /**
     * @var int
     */
    public $date_send_bank;

    /**
     * @var int
     */
    public $date_subscribe;

    /**
     * @var array
     */
    public $documents;

    /**
     * @var \Catalizr\Entity\Fundraisings
     */
    public $fundraising;

    /**
     * @var string
     */
    public $fundraising_external_id;

    /**
     * @var string
     */
    public $fundraising_id;

    /**
     * @var string
     */
    public $funds_type;

    /**
     * @var array
     */
    public $history;

    /**
     * @var string
     */
    public $iban;

    /**
     * @var \Catalizr\Entity\Investors
     */
    public $investor;

    /**
     * @var string
     */
    public $investor_external_id;

    /**
     * @var string
     */
    public $investor_id;

    /**
     * @var float
     */
    public $nb_bons;

    /**
     * @var float
     */
    public $nb_part;

    /**
     * @var int
     */
    public $open_date;

    /**
     * @var float
     */
    public $part_amount;

    /**
     * @var string
     */
    public $part_type;

    /**
     * @var string
     */
    public $payment_mode;

    /**
     * @var array
     */
    public $reports;

    /**
     * @var array
     */
    public $shares;

    /**
     * @var string
     */
    public $status;

    /**
     *
     * @return object
     */
    public function jsonSerialize() {
        $arrayResult = array();

        foreach ($this as $key => $value) {
            if (in_array($key, self::$notAllowedProperties)) {
                continue;
            }
            if (isset($value)) {
                $arrayResult[$key] = $value;
            }
        }

        return $arrayResult;
    }
}
