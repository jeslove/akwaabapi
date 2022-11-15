<?php

namespace DevCoder;

class Sessions implements SessionInterface
{

    public function __construct(?string $cacheExpire = null, ?string $cacheLimiter = null)
    {
        if (session_status() === PHP_SESSION_NONE) {

            if ($cacheLimiter !== null) {
                session_cache_limiter($cacheLimiter);
            }

            if ($cacheExpire !== null) {
                session_cache_expire($cacheExpire);
            }

            session_start();
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return SessionManager
     */
    public function set(string $key, $value): SessionInterface
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function clear(): void
    {
        session_unset();
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

	/**
     * Generate CSRF TOKEN for post requests
     */
    public static function setcsrf()
    {
        if (empty($_SESSION['token']))
        {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['token'];
    }

    /**
     * Verify Tokens before post request
     */
    public static function setTokentime()
    {
        if(empty($_SESSION['token_time']))
        {
            $_SESSION['token_time'] = time() + 300;
        }
        return $_SESSION['token_time'];
    }
}
