<?php

namespace ShipMonk\Interfaces;

interface InsertableList
{
    /**
     * @param string|int $value
     * @return void
     */
    public function insert(string|int $value): void;
}