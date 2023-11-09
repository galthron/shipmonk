<?php
declare(strict_types=1);

namespace ShipMonk;

class SortedLinkedListValidator
{
    const LIST_TYPES = ['integer', 'string'];
    const LIST_ORDER = [SortedLinkedList::ORDER_ASC, SortedLinkedList::ORDER_DESC];

    public static function validateListParams(string $listType, string $sortOrder): void
    {
        if (!in_array($listType, self::LIST_TYPES)) {
            throw new ValidationException('Incorect list type. Only ' . implode(' & ', self::LIST_TYPES) . ' possible');
        }

        if (!in_array($sortOrder, self::LIST_ORDER)) {
            throw new ValidationException('Incorect list sort order. Only ' . implode(' & ', self::LIST_ORDER) . ' possible');
        }
    }

    public static function validateListValue(string $listType, int|string $value): void
    {
        if(gettype($value) !== $listType){
            throw new \Exception('Incorect value type. Only '.$listType.' possible');
        }
    }
}