<?php

namespace ShipMonk\Interfaces;

use ShipMonk\Node;

interface Comparable
{
    /**
     * @param Node $other
     * @return int
     */
    public function compare(Node $other): int;
}