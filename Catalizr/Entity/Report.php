<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 20/06/18
 * Time: 16:43
 */

namespace Catalizr\Entity;


class Report extends \Catalizr\Lib\Entity
{
    /**
     * @var bool
     */
    public $alert_email;

    /**
     * @var string
     */
    public $report;

    /**
     * @var string
     */
    public $report_type;
}
