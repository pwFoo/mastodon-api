<?php

namespace Baguette\Mastodon\Grant;

use Baguette\Mastodon\Service\AuthFactory;
use Baguette\Mastodon\Service\Scope;
use GuzzleHttp\ClientInterface as Client;

/**
 * Mastodon Authorization Code grant
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://tools.ietf.org/html/draft-ietf-oauth-v2-22#section-4.1
 */
class CodeGrant extends Grant
{
    /** @var string */
    private $code;
    /** @var string */
    private $redirect_uri;

    /**
     * @param string $code
     */
    public function __construct($code, $redirect_uri)
    {
        $this->code = $code;
        $this->redirect_uri = $redirect_uri;
    }

    /**
     * @param  Client      $http
     * @param  AuthFactory $factory
     * @param  Scope       $scope
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function auth(Client $http, AuthFactory $factory, Scope $scope)
    {
        return $http->request('POST', static::getPathToOAuthToken($factory->client), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code'  => $this->code,
                'scope' => (string)$scope,
            ] + static::getFormParams($factory),
        ]);
    }
}