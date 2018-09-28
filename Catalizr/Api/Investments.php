<?php

namespace Catalizr\Api;

use Catalizr\Entity\InvestmentLink;
use Catalizr\Lib\Object;
use Catalizr\Pagination;

/**
 * Description of ApiInvestment
 *
 * @author codati
 */
class Investments extends \Catalizr\Lib\Api
{
    /**
     * @var string
     */
    static $classEntity =  "\Catalizr\Entity\Investments";

    /**
     * @var string
     */
    static $prefixTag =  'investments';


    /**
     * @param \Catalizr\Entity\Investments $investments
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function close(\Catalizr\Entity\Investments $investments)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_close_post', null, [$investments->id]);
    }

    /**
     * @param string $status
     * @param Pagination $pagination
     * @return object
     * @throws \Catalizr\Lib\HttpException
     */
    public function collect($status, Pagination $pagination)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_collect_post', null, null, array_merge(['status' => $status], (array) $pagination));
    }

    /**
     * @param \Catalizr\Entity\Investments $investments
     * @param bool $forceConfirm Force the confirm of an investment only if fundraising is closed
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function confirm(\Catalizr\Entity\Investments $investments, $forceConfirm = false)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_confirm_post', null, [$investments->id], ['force' => $forceConfirm ? 'true' : 'false']);
    }

    /**
     * @param \Catalizr\Entity\Investments $investment investment for save
     * @param bool $generateInvestorDocs Documents for investor will be generated if set to true.
     * @param bool $generateCompanyDocs Documents for company will be generated if set to true.
     * @return Object
     * @throws \Catalizr\Lib\HttpException
     */
    public function create(\Catalizr\Entity\Investments &$investment, $generateInvestorDocs = false, $generateCompanyDocs = false)
    {
        if(!isset($investment->fundraising_id))
        {
            if(isset($investment->fundraising))
            {
                $investment->fundraising_id = $investment->fundraising->id;
            }else if(isset($investment->fundraising_external_id))
            {
                $investment->fundraising_id = $this->api->fundraisings->getIdByExternalIid($investment->fundraising_external_id);
            }else{
                throw new \Exception('fundraising or fundraising_id or fundraising_external_id is not set in investment');
            }
        }

        if(!isset($investment->investor_id))
        {
            if(isset($investment->investor))
            {
                $investment->investor_id = $investment->investor->id;
            }else if(isset($investment->investor_external_id))
            {
                $investment->investor_id = $this->api->investors->getIdByExternalIid($investment->investor_external_id);
            }else{
                throw new \Exception('investor or investor_id or investor_external_id is not set in investment');
            }
        }

        if ($generateInvestorDocs) {
            $investment->investor = true;
        }

        if ($generateCompanyDocs) {
            $investment->company = true;
        }

        return parent::create(self::$prefixTag, $investment);
    }

    /**
     * @param string|int|double $iid
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByExternalInvestmentId($iid, \Catalizr\Entity\Documents &$document)
    {
        $id=$this->getIdByExternalIid( $iid);
        $this->createDocumentById(self::$prefixTag,$id,$document);
    }

    /**
     * @param \Catalizr\Entity\Investments $Investment
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByInvestment(\Catalizr\Entity\Investments $Investment, \Catalizr\Entity\Documents &$document)
    {
        $this->createDocumentById(self::$prefixTag,$Investment->id, $document);
    }

    /**
     * @param string $id
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
    public function createDocumentByInvestmentId($id, \Catalizr\Entity\Documents &$document)
    {
        $this->createDocumentById(self::$prefixTag, $id, $document);
    }

    /**
     * @return \Catalizr\Entity\InvestmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function createLink()
    {
        $investmentLinkObject = $this->api->helperRequest->executeReq(self::$prefixTag . '_links_post');

        return new \Catalizr\Entity\InvestmentLink($investmentLinkObject);
    }

    /**
     * @param \Catalizr\Entity\Investments $investment
     * @param \Catalizr\Entity\Report $report
     * @return object
     * @throws \Catalizr\Lib\HttpException
     */
    public function createReport(\Catalizr\Entity\Investments $investment, \Catalizr\Entity\Report $report)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_postReports', $report, [$investment->id]);
    }

    /**
     * @param string|int|double $iid external id
     * @throws \Catalizr\Lib\HttpException
     */
    public function finishByExternalInvestmentId($iid)
    {
        $id = $this->getIdByExternalIid($iid);
        $this->finishByIdInvestment($id);
    }

    /**
     * @param string $id id of catalizr
     * @throws \Catalizr\Lib\HttpException
     */
    public function finishByIdInvestment($id)
    {
        $this->api->helperRequest->executeReq(self::$prefixTag.'_finish', null, [$id]);
    }

    /**
     * @param \Catalizr\Entity\Investments $investment
     * @throws \Catalizr\Lib\HttpException
     */
    public function finishByInvestment(\Catalizr\Entity\Investments $investment)
    {
        $this->finishByIdInvestment($investment->id);
    }

    /**
     * @param \Catalizr\Entity\Investments $investment
     * @throws \Catalizr\Lib\HttpException
     */
    public function generateDocumentsAttestation(\Catalizr\Entity\Investments $investment)
    {
        $this->api->helperRequest->executeReq(self::$prefixTag . '_documents_attestation_post', null, [$investment->id]);
    }

    /**
     * @param int $id
     * @param Pagination|null $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllReports($id, Pagination $pagination = null)
    {
        return parent::getAllById(self::$prefixTag.'_reports', $id, $pagination);
    }

    /**
     * @param Pagination $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllReportsTypes(Pagination $pagination)
    {
        return parent::getAll(self::$prefixTag.'_reports_types', null, $pagination);
    }

    /**
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAllStatus()
    {
        return parent::getAll(self::$prefixTag.'_status');
    }

    /**
     * @param string $id id of catalizr
     * @return \Catalizr\Entity\Investments
     * @throws \Catalizr\Lib\HttpException
     */
    public function getById($id)
    {
        $investment = parent::getById( self::$prefixTag, self::$classEntity, $id);
        $investment->fundraising_id = $investment->fundraising;
        $investment->investor_id = $investment->investor;
        $investment->fundraising = null;
        $investment->investor = null;

        return $investment;
    }

    /**
     * @param string|int|double $iid external id
     * @return \Catalizr\Entity\Investments
     * @throws \Catalizr\Lib\HttpException
     */
    public function getByExternalId($iid)
    {
        return parent::getByExternalId($iid);
    }

    /**
     * @param \Catalizr\Entity\Investments $investments
     * @param Pagination|null $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    public function getHistory(\Catalizr\Entity\Investments $investments, $pagination = null)
    {
        return parent::getAllById(self::$prefixTag . '_history', $investments->id, $pagination);
    }

    /**
     * @param string|int|double $iid external iid
     * @return string
     * @throws \Catalizr\Lib\HttpException
     */
    public function getIdByExternalIid($iid)
    {
        return parent::getIdByExternalIid( self::$prefixTag, $iid);
    }

    /**
     * @param string $linkId
     * @return \Catalizr\Entity\InvestmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLink($linkId)
    {
        $investmentLinkObject = $this->api->helperRequest->executeReq(self::$prefixTag . '_links_get', null, [$linkId]);
        return new \Catalizr\Entity\InvestmentLink($investmentLinkObject);
    }

    /**
     * Get the url of each document in this investment link
     *
     * @param $linkId
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLinkDocumentsUrl($linkId)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_getDocumentsUrl', null, [$linkId]);
    }

    /**
     * @param string $linkId
     * @param string $investorEmail
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function getLinkStep($linkId, $investorEmail = null)
    {
        $params = [];
        if (! empty($investorEmail)) {
            $params['email'] = $investorEmail;
        }

        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_step_get', null, [$linkId], $params);
    }

    /**
     * @param InvestmentLink $investmentLink
     * @param array $emailParams
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function sendLink(\Catalizr\Entity\InvestmentLink $investmentLink, $emailParams = [])
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_send_post', $emailParams, [$investmentLink->id]);
    }

    /**
     * @param InvestmentLink $investmentLink
     * @param array $documentData
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function setLinkDocument(\Catalizr\Entity\InvestmentLink $investmentLink, $documentData = [])
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_links_documents_post', $documentData, [$investmentLink->id]);
    }

    /**
     * Save the current step of the investments link
     *
     * @param InvestmentLink $investmentLink
     * @param string $step
     * @return mixed
     * @throws \Catalizr\Lib\HttpException
     */
    public function setStep(\Catalizr\Entity\InvestmentLink $investmentLink, $step)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_step_post', ['investment_link_id' => $investmentLink->id, 'step' => $step]);
    }

    /**
     * @param \Catalizr\Entity\InvestmentLink $investmentLink
     * @return \Catalizr\Entity\InvestmentLink
     * @throws \Catalizr\Lib\HttpException
     */
    public function updateLink(\Catalizr\Entity\InvestmentLink $investmentLink)
    {
        return parent::update(self::$prefixTag . '_links', $investmentLink);
    }
}