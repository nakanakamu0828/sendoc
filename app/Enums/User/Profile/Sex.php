<?php
declare(strict_types=1);

namespace App\Enums\User\Profile;

use BenSampo\Enum\Enum;

final class Sex extends Enum
{
    /** 0:未設定 */
    const None = 0;
    /** 1:男性 */
    const Male = 1;
    /** 2:女性 */
    const Female = 2;
    /** 9:未回答 */
    const Unanswered = 9;

    public static function getDescription($value): string
    {
        foreach(Sex::getValues() as $v) {
            if ($value === $v) {
                return __('enum.user_profile.sex.' . strtolower(Sex::getKey($v)));
            }
        }
        return self::getKey($value);
    }
}
