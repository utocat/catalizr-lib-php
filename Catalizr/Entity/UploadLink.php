<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 26/06/18
 * Time: 10:03
 */

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

class UploadLink extends \Catalizr\Lib\Entity
{
    use Timestampable;

    /**
     * @var \Catalizr\Entity\UploadReference[]
     */
    public $datas;

    /**
     * @var string
     */
    public $url;
}
