<?php

/*
 * This file is part of Laravel WuBook.
 *
 * (c) Filippo Galante <filippo.galante@b-ground.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jsehersan\LaravelWubook;

use fXmlRpc\Client;
use fXmlRpc\Parser\NativeParser;
use fXmlRpc\Parser\XmlReaderParser;
use fXmlRpc\Serializer\NativeSerializer;
use Illuminate\Contracts\Config\Repository;
use Jsehersan\LaravelWubook\Exceptions\WuBookException;
use Jsehersan\LaravelWubook\Api\WuBookAuth;
use Jsehersan\LaravelWubook\Api\WuBookAvailability;
use Jsehersan\LaravelWubook\Api\WuBookCancellationPolicies;
use Jsehersan\LaravelWubook\Api\WuBookChannelManager;
use Jsehersan\LaravelWubook\Api\WuBookCorporate;
use Jsehersan\LaravelWubook\Api\WuBookExtras;
use Jsehersan\LaravelWubook\Api\WuBookPrices;
use Jsehersan\LaravelWubook\Api\WuBookReservations;
use Jsehersan\LaravelWubook\Api\WuBookRestrictions;
use Jsehersan\LaravelWubook\Api\WuBookRooms;
use Jsehersan\LaravelWubook\Api\WuBookTransactions;

/**
 * This is the WuBook manager class.
 *
 * @author Filippo Galante <filippo.galante@b-ground.com>
 */
class WuBookManager
{

    /**
     * @var string
     */
    const ENDPOINT = 'https://wired.wubook.net/xrws/';

    /**
     * @var array
     */
    private $config;

    /**
     * @var Illuminate\Cache\Repository
     */
    private $cache;

    /**
     * Create a new WuBook Instance.
     *
     * @param Repository $config
     * @throws WuBookException
     */
    public function __construct(Repository $config)
    {
        // Setup credentials
        $this->config = array_only($config->get('wubook'), ['username', 'password', 'provider_key', 'lcode']);
        // Credentials check
        if (!array_key_exists('username', $this->config) || !array_key_exists('password', $this->config) || !array_key_exists('provider_key', $this->config) || !array_key_exists('lcode', $this->config)) {
            throw new WuBookException('Credentials are required!');
        }

        if (!array_key_exists('cache_token', $this->config)) {
            $this->config['cache_token'] = false;
        }

        // Utilities
        $this->cache = app()['cache'];
    }

    /**
     * Auth API
     *
     * @return Jsehersan\LaravelWubook\Api\WuBookAuth
     */
    public function auth()
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());
        return new WuBookAuth($this->config, $this->cache, $client);
    }

    /**
     * Availability API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookAvailability
     */
    public function availability($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null,new XmlReaderParser(), new NativeSerializer());

        return new WuBookAvailability($this->config, $this->cache, $client, $token);
    }

    /**
     * Cancellation polices API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookCancellationPolicies
     */
    public function cancellation_policies($token = null)
    {
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookCancellationPolicies($this->config, $this->cache, $client, $token);
    }

    /**
     * Channel manager API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookChannelManager
     */
    public function channel_manager($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookChannelManager($this->config, $this->cache, $client, $token);
    }

    /**
     * Corporate function API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookCorporate
     */
    public function corporate_functions($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookCorporate($this->config, $this->cache, $client, $token);
    }

    /**
     * Extra functions API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookExtras
     */
    public function extras($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookExtras($this->config, $this->cache, $client, $token);
    }

    /**
     * Prices API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookPrices
     */
    public function prices($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookPrices($this->config, $this->cache, $client, $token);
    }

    /**
     * Reservations API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookPrices
     */
    public function reservations($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookReservations($this->config, $this->cache, $client, $token);
    }

    /**
     * Restrictions API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookRestrictions
     */
    public function restrictions($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookRestrictions($this->config, $this->cache, $client, $token);
    }

    /**
     * Rooms API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookRooms
     */
    public function rooms($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());
        return new WuBookRooms($this->config, $this->cache, $client, $token);
    }

    /**
     * Transactions API
     *
     * @param string $token
     * @return Jsehersan\LaravelWubook\Api\WuBookTransactions
     */
    public function transactions($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookTransactions($this->config, $this->cache, $client, $token);
    }

    /**
     * Username getter.
     *
     * @return string
     */
    public function get_username()
    {
        return $this->username;
    }

    /**
     * Password getter.
     *
     * @return string
     */
    public function get_password()
    {
        return $this->password;
    }

    /**
     * Provider key getter.
     *
     * @return string
     */
    public function get_provider_key()
    {
        return $this->provider_key;
    }

    /**
     * Client getter.
     *
     * @return PhpXmlRpc\Client
     */
    public function get_client()
    {
        return $this->client;
    }
}
