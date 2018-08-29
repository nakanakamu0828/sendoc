<?php

namespace App\Enums\Member;

use BenSampo\Enum\Enum;

final class Role extends Enum
{
    /** admin:管理者 */
    const Admin = 'admin';
    /** user:一般ユーザー */
    const User = 'user';
    /** 税理士を用意する？ */
    // const Govament = 'govament';

    public static function getDescription($value): string
    {
        foreach(Role::getValues() as $v) {
            if ($value === $v) {
                return __('enum.member.role.' . strtolower(Role::getKey($v)));
            }
        }
        return self::getKey($value);
    }
}
