<?php

namespace ShipMonk;

interface Comparable
{
    public function compare(Node $other): int;
}