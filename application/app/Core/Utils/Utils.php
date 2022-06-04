<?php
declare(strict_types=1);

namespace App\Core\Utils;

use App\Core\Constants;

/**
 * 通用工具类
 */
class Utils
{

    /**
     * UUID
     */
    public static function uuid(): string
    {
        return uniqid();
    }

    /**
     * 密码加密
     */
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * 密码比对
     */
    public static function check(string $password, string $encoded): bool
    {
        return password_verify($password, $encoded);
    }

    /**
     * 获取当前支持的语言
     */
    public static function getLangType(string $local): string
    {
        $local = strtolower(trim($local));
        return match ($local) {
            'zh_cn', 'zh_tw', 'en_us' => $local,
            default => Constants::LOCALE,
        };
    }

}
