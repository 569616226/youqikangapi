<?php

namespace App\Containers\Authentication\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authentication\UI\API\Requests\LoginRequest;
use App\Containers\Authentication\UI\API\Requests\LogoutRequest;
use App\Containers\Authentication\UI\API\Requests\RefreshRequest;
use App\Containers\Authentication\UI\API\Requests\WechatLoginRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Support\Facades\Cookie;

/**
 * Class Controller
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Controller extends ApiController
{

    /**
     * @param \App\Containers\Authentication\UI\API\Requests\LogoutRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutRequest $request)
    {
        Apiato::call('Authentication@ApiLogoutAction', [$request]);

        return $this->accepted([
            'message' => 'Token revoked successfully.',
        ])->withCookie(Cookie::forget('refreshToken'));
    }

    /**
     * This `proxyLoginForAdminWebClient` exist only because we have `AdminWebClient`
     * The more clients (Web Apps). Each client you add in the future, must have
     * similar functions here, with custom route for dedicated for each client
     * to be used as proxy when contacting the OAuth server.
     * This is only to help the Web Apps (JavaScript clients) hide
     * their ID's and Secrets when contacting the OAuth server and obtain Tokens.
     *
     * @param \App\Containers\Authentication\UI\API\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function proxyLoginForAdminWebClient(LoginRequest $request)
    {
        return Apiato::call('Authentication@ProxyApiLoginAction', [
            $request,
            env('CLIENT_WEB_ADMIN_ID'),
            env('CLIENT_WEB_ADMIN_SECRET'),
        ]);

    }

    /**
     * This `proxyLoginForAdminWebClient` exist only because we have `AdminWebClient`
     * The more clients (Web Apps). Each client you add in the future, must have
     * similar functions here, with custom route for dedicated for each client
     * to be used as proxy when contacting the OAuth server.
     * This is only to help the Web Apps (JavaScript clients) hide
     * their ID's and Secrets when contacting the OAuth server and obtain Tokens.
     *
     * @param \App\Containers\Authentication\UI\API\Requests\WechatLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function proxyLoginForWechatWebClient(WechatLoginRequest $request)
    {
        return Apiato::call('Authentication@ProxyApiWechatLoginAction', [
            $request
        ]);

    }

    /**
     * Read the comment in the function `proxyLoginForAdminWebClient`
     *
     * @param \App\Containers\Authentication\UI\API\Requests\RefreshRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function proxyRefreshForAdminWebClient(RefreshRequest $request)
    {
        $result = Apiato::call('Authentication@ProxyApiRefreshAction', [
            $request,
            env('CLIENT_WEB_ADMIN_ID'),
            env('CLIENT_WEB_ADMIN_SECRET'),
        ]);

        return $this->json($result['response-content'])->withCookie($result['refresh-cookie']);
    }
}