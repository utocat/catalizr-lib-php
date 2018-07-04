<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 26/06/18
 * Time: 10:10
 */

namespace Catalizr\Entity;


class UploadReferenceDocument
{
    const TYPE_BULLETIN_SOUSCRIPTION = "BULLETIN_SOUSCRIPTION";
    const TYPE_KBIS = "KBIS";
    const TYPE_LETTRE_ENGAGEMENT = "LETTRE_ENGAGEMENT";
    const TYPE_LETTRE_INFORMATION = "LETTRE_INFORMATION";
    const TYPE_ORDRE_VIREMENT = "ORDRE_VIREMENT";
    const TYPE_PV_OUVERTURE_CAPITAL = "PV_OUVERTURE_CAPITAL";
    const TYPE_RIB_COMPANY = "RIB_COMPANY";
    const TYPE_STATUS = "STATUS";
    const TYPE_TITRE_PROPRIETE = "TITRE_PROPRIETE";

    /**
     * @var string
     */
    public $document_type;

    /**
     * @var int
     */
    public $uploaded_date;
}
