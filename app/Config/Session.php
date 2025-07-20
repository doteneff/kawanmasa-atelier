<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\FileHandler; // Keep this if you want a local fallback
use CodeIgniter\Session\Handlers\RedisHandler; // Make sure this is imported

class Session extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Session Driver
     * --------------------------------------------------------------------------
     */
    public string $driver = RedisHandler::class; // !!! IMPORTANT CHANGE HERE !!!

    /**
     * --------------------------------------------------------------------------
     * Session Cookie Name
     * --------------------------------------------------------------------------
     */
    public string $cookieName = 'ci_session';

    /**
     * --------------------------------------------------------------------------
     * Session Expiration
     * --------------------------------------------------------------------------
     */
    public int $expiration = 7200;

    /**
     * --------------------------------------------------------------------------
     * Session Save Path
     * --------------------------------------------------------------------------
     */
    public ?string $savePath = null; // !!! IMPORTANT CHANGE HERE !!!

    /**
     * --------------------------------------------------------------------------
     * Session Match IP
     * --------------------------------------------------------------------------
     */
    public bool $matchIP = false;

    /**
     * --------------------------------------------------------------------------
     * Session Time to Update
     * --------------------------------------------------------------------------
     */
    public int $timeToUpdate = 300;

    /**
     * --------------------------------------------------------------------------
     * Session Regenerate Destroy
     * --------------------------------------------------------------------------
     */
    public bool $regenerateDestroy = false;

    /**
     * --------------------------------------------------------------------------
     * Session Database Group
     * --------------------------------------------------------------------------
     */
    public ?string $DBGroup = null;

    /**
     * --------------------------------------------------------------------------
     * Lock Retry Interval (microseconds)
     * --------------------------------------------------------------------------
     */
    public int $lockRetryInterval = 100_000;

    /**
     * --------------------------------------------------------------------------
     * Lock Max Retries
     * --------------------------------------------------------------------------
     */
    public int $lockMaxRetries = 300;

    // --- IMPORTANT: Add this constructor for Heroku Redis Cloud ---
    public function __construct()
    {
        parent::__construct();

        // Check if on Heroku (by REDISCLOUD_URL) AND Redis driver is selected
        if ($this->driver === RedisHandler::class && getenv('REDISCLOUD_URL')) {
            $redisUrl = parse_url(getenv('REDISCLOUD_URL'));

            if ($redisUrl) {
                // Heroku Redis Cloud usually uses 'rediss' scheme for TLS.
                // php-redis (the extension CI uses) expects 'tls' for encrypted connections.
                $scheme = isset($redisUrl['scheme']) && $redisUrl['scheme'] === 'rediss' ? 'tls' : 'tcp';

                $this->savePath = sprintf(
                    '%s://%s:%d?auth=%s&timeout=5',
                    $scheme,
                    $redisUrl['host'],
                    $redisUrl['port'],
                    $redisUrl['pass'] ?? ''
                );
            }
        } elseif ($this->driver === FileHandler::class) {
            // Fallback for local development if you want to use file sessions there
            // This assumes you might run it locally without REDISCLOUD_URL set.
            $this->savePath = WRITEPATH . 'session';
        }
    }
}