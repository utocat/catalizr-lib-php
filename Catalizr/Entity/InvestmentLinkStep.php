<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 22/06/18
 * Time: 10:30
 */

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

class InvestmentLinkStep extends \Catalizr\Lib\Entity
{
    use Timestampable;

    const STEP_CONFIRM = 'CONFIRM';
    const STEP_END = 'END';
    const STEP_FORM = 'FORM';
    const STEP_INIT = 'INIT';
    const STEP_SIGN = 'SIGN';
    const STEP_UPLOAD = 'UPLOAD';

    /**
     * @var int
     */
    public $date;

    /**
     * @var string
     */
    public $emailCompany;

    /**
     * @var string
     */
    public $emailInvestor;

    /**
     * @var array
     */
    public $emailsBank;

    /**
     * @var string
     */
    public $investment_link_id;

    /**
     * @var string
     */
    public $step;
}
