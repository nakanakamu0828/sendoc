<?php

namespace App\Enums\Organization;

use BenSampo\Enum\Enum;

final class Type extends Enum
{
    /** corporation:法人 */
    const Corporation = 'corporation';
    /** solo:個人事業主 */
    const Solo = 'solo';

    public static function getDescription($value): string
    {
        foreach(Type::getValues() as $v) {
            if ($value === $v) {
                return __('enum.organization.type.' . strtolower(Type::getKey($v)));
            }
        }
        return self::getKey($value);
    }
}
