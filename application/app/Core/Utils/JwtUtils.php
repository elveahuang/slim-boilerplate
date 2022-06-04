<?php
declare(strict_types=1);

namespace App\Core\Utils;

use Exception;
use Firebase\JWT\JWT;

/**
 * JwtUtils
 */
class JwtUtils
{

    public static string $key = 'slim';

    /**
     * 新建登陆凭证
     *
     * @param array $token 登陆凭证
     * @return string
     * @throws Exception
     */
    public static function createJwtToken(array $token): string
    {
        return JWT::encode($token, JwtUtils::$key);
    }

    /**
     * 解析登陆凭证
     *
     * @param string $token
     * @return object
     */
    public static function parseJwtToken(string $token): object
    {
        return JWT::decode($token, JwtUtils::$key, ['HS256']);
    }

    /**
     * 解析访问凭证
     *
     * @param string $token
     * @return object
     */
    public static function parseAccessToken(string $token): object
    {
        return JwtUtils::parseJwtToken($token);
    }

    /**
     * 解析刷新凭证
     *
     * @param string $token
     * @return object
     */
    public static function parseRefreshToken(string $token): object
    {
        return JwtUtils::parseJwtToken($token);
    }

}
