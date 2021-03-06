<?php

namespace Baguette\Mastodon;

use Baguette\Mastodon\Service\SessionStorage;

/**
 * Mastodon Service
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @method Entity\Account fetchAccount(int $id)
 * @method Entity\Account getAccountCurrentUser()
 * @method Entity\Account updateAccount(array $update_data)
 * @method Entity\Account[] getAccountFollowers(int $account_id)
 * @method Entity\Account[] getBlocks(array $options = [])
 * @method Entity\Status[] getFavourites(array $options = [])
 * @method Entity\Account[] getFollowRequests(array $options = [])
 * @method Entity\Status getStatus($status_id)
 * @method Entity\Status postStatus(Service\Toot $toot)
 */
final class Mastodon
{
    use \Teto\Object\PrivateGetter;
    use \Teto\Object\ReadOnly;

    /** @var Client */
    private $client;
    /** @var SessionStorage */
    private $session;

    public function __construct(Client $client, SessionStorage $session)
    {
        $this->client = $client;
        $this->session = $session;
    }

    /**
     * @return Entity\Entity
     */
    public function __call($name, array $args)
    {
        return call_user_func_array(
            [Requester::class, $name],
            array_merge([$this->client, $this->session], $args)
        );
    }
}
