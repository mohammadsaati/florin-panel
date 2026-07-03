<?php

namespace App\Enums;

use App\Commons\Types\KeyValueType;

trait ValuesTrait
{
    /**
     * @return list<int|string>
     */
    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $item) {
            $values[] = $item->value;
        }

        return $values;
    }

    public static function valuesAsString(): string
    {
        $values = [];
        foreach (self::cases() as $item) {
            $values[] = $item->value;
        }

        return implode(',', $values);
    }

    /**
     * @return array<string|int, string>
     */
    public static function toSimpleKeyValue(): array
    {
        $tmp = [];
        foreach (self::cases() as $item) {
            $tmp[$item->value] = $item->trans();
        }

        return $tmp;
    }

    /**
     * @return array<KeyValueType>|KeyValueType[]
     */
    public static function toKeyValueType(): array
    {
        $tmp = [];
        foreach (self::cases() as $item) {
            $tmp[] = key_value_type_object(
                title: $item->trans(),
                value: $item->value
            );
        }

        return $tmp;
    }
}
