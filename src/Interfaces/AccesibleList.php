<?php

namespace ShipMonk\Interfaces;

interface AccesibleList
{
    /**
     * @return int|string|null
     */
    public function first(): null|int|string;

    /**
     * @return int|string|null
     */
    public function last(): null|int|string;

    /**
     * @param int $index
     * @return int|string|null
     */
    public function get(int $index): null|int|string;

    /**
     * @param int|string $value
     * @return false|int|string
     */
    public function contains(int|string $value): false|int|string;
}