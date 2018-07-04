<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 28/06/18
 * Time: 16:22
 */

namespace Catalizr\Api;

use Catalizr\Lib\Api;

class Authentication extends Api
{
    /**
     * @var string
     */
    static $prefixTag = 'authentification';

    /**
     * Requests a password reset
     *
     * @param array $requestData An array containing email (required), redirection_url (optionnal, the url to redirect after reset).
     * Example:
     * [
     *      'email' => 'contact@utocat.fr',
     *      'redirection_url' => 'http://dev.catalizr.eu/invest-complete/5b0e863975738c24a4ca62f0'
     * ]
     *
     * @throws \Catalizr\Lib\HttpException
     */
    public function requestPasswordReset($requestData)
    {
        $this->api->helperRequest->executeReq(self::$prefixTag . '_password_request_post', $requestData);
    }

    /**
     * Checks if password reset request is valid
     *
     * @param array $requestData An array containing email (required), token (required, the token send in an email by method requestPasswordReset).
     * Example:
     * [
     *      'email' => 'contact@utocat.fr',
     *      'token' => 'theTokenGeneratedBy_requestPasswordReset'
     * ]
     * @return object
     * @throws \Catalizr\Lib\HttpException
     */
    public function passwordReset($requestData)
    {
        return $this->api->helperRequest->executeReq(self::$prefixTag . '_password_reset_post', $requestData);
    }
}
