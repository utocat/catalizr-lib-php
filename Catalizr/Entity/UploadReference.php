<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 26/06/18
 * Time: 10:06
 */

namespace Catalizr\Entity;


class UploadReference
{
    /**
     * @var \Catalizr\Entity\UploadReferenceDocument[]
     */
    public $documents;

    /**
     * @var string
     */
    public $reference_id;

    /**
     * @var string
     */
    public $reference_type;
}
