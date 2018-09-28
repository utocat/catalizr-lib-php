<?php

namespace Catalizr\Lib;

/**
 * Description of HelperRequest
 *
 * @author codati
 */
class HelperRequest extends Object{
    /**
     *
     * @var string
     */
    private $jwt;

    private $listTag = array(
        'authentification' => array('url' => '/authorize', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'authentification_password_request_post' => array('url' => '/authorize/password/request', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'authentification_password_reset_post' => array('url' => '/authorize/password/reset', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'banks_getAll' => array('url' => '/banks', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'companies_get' => array('url' => '/companies/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'companies_getAll' => array('url' => '/companies', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'companies_getBySiren' => array('url' => '/companies/siren/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'companies_getFundraisings' => array('url' => '/companies/%s/fundraisings', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'companies_getiid' => array('url' => '/companies/iid/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'companies_post' => array('url' => '/companies', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'companies_postDocuments' => array('url' => '/companies/%s/documents', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'companies_postFundraisings' => array('url' => '/companies/%s/fundraisings', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'companies_put' => array('url' => '/companies/%s', 'method' => RequestType::PUT, 'expectedCode' => array(204)),
        'companies_search' => array('url' => '/companies/search', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'companies_search_siren' => array('url' => '/companies/search/siren', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'documents_get' => array('url' => '/documents/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'documents_getMetadata' => array('url' => '/documents/%s/datas', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'documents_put' => array('url' => '/documents/%s', 'method' => RequestType::PUT, 'expectedCode' => array(204)),
        'documents_sign_post' => array('url' => '/documents/sign', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'fundraisings_close' => array('url' => '/fundraisings/%s/close', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'fundraisings_get' => array('url' => '/fundraisings/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'fundraisings_getiid' => array('url' => '/fundraisings/iid/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'fundraisings_investments_getAll' => array('url' => '/fundraisings/%s/investments', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'fundraisings_postDocuments' => array('url' => '/fundraisings/%s/documents', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'fundraisings_put' => array('url' => '/fundraisings/%s', 'method' => RequestType::PUT, 'expectedCode' => array(204)),
        'investments_close_post' => array('url' => '/investments/%s/close', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'investments_collect_post' => array('url' => '/investments/collect', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'investments_confirm_post' => array('url' => '/investments/%s/confirm', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'investments_documents_attestation_post' => array('url' => '/investments/%s/documents/attestation', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'investments_finish' => array('url' => '/investments/%s/finish', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'investments_get' => array('url' => '/investments/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_getiid' => array('url' => '/investments/iid/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_history_getAll' => array('url' => '/investments/%s/history', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_links_documents_post' => array('url' => '/investments/links/%s/documents', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'investments_links_get' => array('url' => '/investments/links/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_links_getDocumentsUrl' => array('url' => '/investments/links/%s/documents/url', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_links_post' => array('url' => '/investments/links', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'investments_links_put' => array('url' => '/investments/links/%s', 'method' => RequestType::PUT, 'expectedCode' => array(204)),
        'investments_links_send_post' => array('url' => '/investments/links/%s/send', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'investments_links_step_get' => array('url' => '/investments/links/%s/step', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_status_getAll' => array('url' => '/investments/status', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_step_post' => array('url' => '/investments/step', 'method' => RequestType::POST, 'expectedCode' => array(204)),
        'investments_reports_getAll' => array('url' => '/investments/%s/reports', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_reports_types_getAll' => array('url' => '/investments/reports', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investments_post' => array('url' => '/investments', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'investments_postDocuments' => array('url' => '/investments/%s/documents', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'investments_postReports' => array('url' => '/investments/%s/reports', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'investors_get' => array('url' => '/investors/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investors_getAll' => array('url' => '/investors', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investors_getByEmail' => array('url' => '/investors/email/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investors_getiid' => array('url' => '/investors/iid/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investors_investments_getAll' => array('url' => '/investors/%s/investments', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'investors_post' => array('url' => '/investors', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'investors_put' => array('url' => '/investors/%s', 'method' => RequestType::PUT, 'expectedCode' => array(204)),
        'reports_codes_get' => array('url' => '/reports/codes/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'reports_get' => array('url' => '/reports/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'shares_links_get' => array('url' => '/shares/links/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'shares_links_post' => array('url' => '/shares/links', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'shares_links_send_post' => array('url' => '/shares/links/%s/send', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'signatures_links_envelope_post' => array('url' => '/signatures/links/%s/envelope', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'signatures_links_get' => array('url' => '/signatures/links/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'signatures_links_post' => array('url' => '/signatures/links', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'signatures_links_send_post' => array('url' => '/signatures/links/%s/send', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'uploads_links_get' => array('url' => '/uploads/links/%s', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'uploads_links_post' => array('url' => '/uploads/links', 'method' => RequestType::POST, 'expectedCode' => array(201)),
        'uploads_links_send_post' => array('url' => '/uploads/links/%s/send', 'method' => RequestType::POST, 'expectedCode' => array(200)),
        'utils_address_details_get' => array('url' => '/utils/address/%s/details', 'method' => RequestType::GET, 'expectedCode' => array(200)),
        'utils_address_post' => array('url' => '/utils/address', 'method' => RequestType::POST, 'expectedCode' => array(200)),
    );

    private function getJwt($force = false)
    {
        $pathJWT = $this->api->config->folderCache . DIRECTORY_SEPARATOR .'jwt.txt';

        if (!$force) {
            if (isset($this->jwt)) {
                return $this->jwt;
            }

            if (file_exists($pathJWT)) {
                $this->jwt = file_get_contents($pathJWT);
                return $this->jwt;
            }
        }

        if (! file_exists( $this->api->config->folderCache)) {
            mkdir($this->api->config->folderCache, 0700, true);
        }
        $response = $this->executeReq('authentification',array('apiPublicKey' => $this->api->config->publicKey));
        $this->jwt = $response->authorizationToken;
        file_put_contents($pathJWT,$this->jwt);

        return $this->jwt;
    }

    public function executeReq($tag, $data = null, $dataUrl = null, $params = null, $optionCurl = array(), $retry = true)
    {
        $url = $this->api->config->url . $this->listTag[$tag]['url'];
        if ($dataUrl) {
            $dataUrl = array_map("rawurlencode",$dataUrl);
            $url = $this->api->config->url . sprintf( $this->listTag[$tag]['url'], ...$dataUrl);
        }
        if ($params) {
            $url .= "?".http_build_query($params);
        }

        $header = array();
        $curl = curl_init($url);

        $json= '';
        if ($data) {
            $header[] = 'Content-Type: application/json';
            $json = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        }

        if ($tag !== 'authentification') {
           $header[] = 'authorization: a '.$this->getJwt();
        }

        $nonce = round(microtime(true) * 1000);

        $hmac = hash_hmac('sha512',$nonce . $url . $json, $this->api->config->privateKey);

        $header[]= "x-api-signature: $hmac";
        $header[]= "x-api-nonce: $nonce";

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->listTag[$tag]['method']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt_array($curl, $optionCurl);
        $response = curl_exec($curl) ;
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (in_array($httpcode, $this->listTag[$tag]['expectedCode'])) {
            $responseDecode = json_decode($response);
            if ($responseDecode) {
                return $responseDecode;
            }

            return $response;
        } else {
            if ($httpcode === 401 && $retry && $tag !== 'authentification') {
                $this->getJwt(true);
                $this->executeReq($tag, $data, $dataUrl, $params, $optionCurl, false);
            } else {
                throw new HttpException($response, $httpcode);
            }
        }
    }

    public function executeUpload($file,$url ,$type_mime,$retry=true)
    {
        $header = array('Content-Type: '.$type_mime);

        $nonce = round(microtime(true) * 1000);

        stream_wrapper_register("catalizr", "\Catalizr\Lib\CatalizrSteam");
        $urlCatalizr= "catalizr://concat/$file?&data=" . $nonce . $url;
        $hmac = hash_hmac_file('sha512',$urlCatalizr, $this->api->config->privateKey);
        stream_wrapper_unregister('catalizr');
        $header[] = "x-api-signature: $hmac";
        $header[] = "x-api-nonce: $nonce";
        $header[] = 'authorization: a '.$this->getJwt();

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_INFILE, fopen($file, "rb"));
        curl_setopt($curl, CURLOPT_INFILESIZE, filesize($file));
        curl_setopt($curl, CURLOPT_PUT, true);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10000);

        $response = curl_exec($curl) ;
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpcode=== 201) {
            $responseDecode = json_decode($response);
            if ($responseDecode) {
                return $responseDecode;
            }
            return $response;
        } else {
            if ($httpcode === 401 && $retry) {
                $this->getJwt(true);
                $this->executeUpload($file, $url, $type_mime,false);
            } else {
                throw new HttpException($response, $httpcode);
            }
        }
    }
}
