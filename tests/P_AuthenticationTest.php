<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 28/06/18
 * Time: 17:19
 */

require_once 'TestMain.php';

class P_AuthenticationTest extends TestMain
{
    /**
     * @test
     *
     * @return object
     * @throws \Catalizr\Lib\HttpException
     */
    public function requestPasswordReset()
    {
        $requestData = [
            'email' => 'support@catalizr.eu',
            'redirection_url' => 'http://dev.catalizr.eu/invest-complete/5b0e863975738c24a4ca62f0',
        ];

        $this->api->authentication->requestPasswordReset($requestData);
    }

    // TODO: add test for $this->api->authentication->passwordReset($requestData)
    // -> need to have the token send in email by $this->api->authentication->requestPasswordReset($requestData)
}
