<?php

namespace ShipMonk;

/** @psalm-suppress UnusedProperty */
class Node implements Comparable
{

    public function __construct(private readonly string|int $value, private ?Node $next = null)
    {
    }

    public function compare(?Node $other): int
    {
        if ($other === null) {
            return 1;
        }

        if (is_int($this->value)) {
            if ($this->value > $other->value) {
                return 1;
            }
            if ($this->value < $other->value) {
                return -1;
            }
            if ($this->value === $other->value) {
                return 0;
            }
        }

        /** @psalm-suppress InvalidScalarArgument */
        return strcasecmp($this->value, $other->value);
    }


    public function getValue(): int|string
    {
        return $this->value;
    }

    public function getNext(): ?Node
    {
        return $this->next;
    }

    public function setNext(?Node $next): void
    {
        $this->next = $next;
    }

}