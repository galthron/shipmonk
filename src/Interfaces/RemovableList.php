<?php

namespace ShipMonk\Interfaces;

interface RemovableList
{
    /**
     * @param int $index
     * @return void
     */
    public function removeFrom(int $index): void;
}