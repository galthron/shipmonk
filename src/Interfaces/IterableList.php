<?php

namespace ShipMonk\Interfaces;

interface IterableList
{
    /**
     * @return int|string|null
     */
    public function current(): null|int|string;

    /**
     * @return int|string|null
     */
    public function next(): null|int|string;

    /**
     * @return void
     */
    public function rewind(): void;
}