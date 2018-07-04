<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 14/06/18
 * Time: 09:42
 */

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

class ReportTemplate extends \Catalizr\Lib\Entity
{
    use Timestampable;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $mail_body;

    /**
     * @var string
     */
    public $mail_subject;
}
