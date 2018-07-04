<?php

namespace Catalizr\Entity;

use Catalizr\Lib\Traits\Timestampable;

/**
 * Description of Banks
 *
 * @author codati
 */
class Documents extends \Catalizr\Lib\Entity
{
    use Timestampable;

    const ORIGIN_GENERATE = 'generate';
    const ORIGIN_UPLOADED = 'uploaded';

    const REF_TYPE_COMPANY = 'company';
    const REF_TYPE_DOCUMENT = 'document';
    const REF_TYPE_FUNDRAISING = 'fundraising';
    const REF_TYPE_INVESTMENT = 'investment';
    const REF_TYPE_LINKS = 'links';

    /**
     * @var array
     */
    static $notAllowedProperties = [
        'path_to_file',
    ];

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $name_stored;

    /**
     * @var string
     */
    public $origin;

    /**
     * @var string
     */
    public $path_to_file;

    /**
     * @var string
     */
    public $reference_id;

    /**
     * @var string
     */
    public $reference_type;

    /**
     * @var int
     */
    public $signature_date;

    /**
     * @var string
     */
    public $signature_status;

    /**
     * @var bool
     */
    public $stored;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $type_mime;


    /**
     * @return object
     */
    public function jsonSerialize() {
        $arrayResult = array();

        foreach ($this as $key => $value) {
            if(in_array($key,self::$notAllowedProperties) )
            {
                continue;
            }
            if(isset($value))
            {
                $arrayResult[$key] = $value;
            }
        }
        return $arrayResult;
     }
}
