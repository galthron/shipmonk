<?php

declare(strict_types=1);

namespace ShipMonk;

use ShipMonk\Interfaces\AccesibleList;
use ShipMonk\Interfaces\InsertableList;
use ShipMonk\Interfaces\IterableList;
use ShipMonk\Interfaces\RemovableList;
use ShipMonk\Validators\SortedLinkedListValidator;

class SortedLinkedList implements \Countable, InsertableList, RemovableList, IterableList, AccesibleList
{
    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    private ?Node $head = null;
    private ?Node $tail = null;
    private ?Node $current = null;
    private int $length = 0;

    public function __construct(private readonly string $listType, private readonly string $sortOrder = self::ORDER_ASC)
    {
        SortedLinkedListValidator::validateListParams($this->listType, $this->sortOrder);
    }

    /**
     * @param string|int $value
     * @return void
     * @throws \Exception
     */
    public function insert(string|int $value): void
    {
        SortedLinkedListValidator::validateListValue($this->listType, $value);

        $newNode = new Node($value);

        if ($this->sortOrder === self::ORDER_ASC) {
            $this->insertAsc($newNode);
        } else {
            $this->insertDesc($newNode);
        }

        $this->rewind();
        $this->length++;
    }

    /**
     * @param Node $newNode
     * @return void
     */
    private function insertDesc(Node $newNode): void
    {
        if ($this->isEmpty()) {
            $this->init($newNode);
            return;
        }

        if ($newNode->compare($this->head) > 0) {
            $this->insertFirst($newNode);
            return;
        }

        if ($newNode->compare($this->tail) <= 0) {
            $this->insertLast($newNode);
            return;
        }

        $this->insertSorted($newNode);
        return;
    }

    /**
     * @param Node $newNode
     * @return void
     */
    private function insertAsc(Node $newNode): void
    {
        if ($this->isEmpty()) {
            $this->init($newNode);
            return;
        }
        if ($newNode->compare($this->head) < 0) {
            $this->insertFirst($newNode);
            return;
        }
        if ($newNode->compare($this->tail) >= 0) {
            $this->insertLast($newNode);
            return;
        }

        $this->insertSorted($newNode);
        return;
    }

    /**
     * @param Node $node
     * @return void
     */
    private function init(Node $node): void
    {
        $this->head = $node;
        $this->tail = $this->head;
    }

    /**
     * @param Node $newNode
     * @return void
     */
    private function insertFirst(Node $newNode): void
    {
        if($this->isEmpty()) {
            $this->init($newNode);
        }

        $newNode->setNext($this->head);
        $this->head = $newNode;
    }

    /**
     * @param Node $newNode
     * @return void
     */
    private function insertLast(Node $newNode): void
    {
        if($this->isEmpty()) {
            $this->init($newNode);
        }

        /** @psalm-suppress PossiblyNullReference */
        $this->tail->setNext($newNode);
        $this->tail = $newNode;
    }

    /**
     * @param Node $newNode
     * @return void
     */
    private function insertSorted(Node $newNode): void
    {
        if($this->isEmpty()) {
            $this->init($newNode);
        } else {
            $node = $this->head;
            /** @psalm-suppress PossiblyNullReference */
            while ($node->getNext() !== null) {
                /** @var Node $nextNode */
                $nextNode = $node->getNext();
                if ($this->isInBetween($node, $nextNode, $newNode)) {
                    $this->insertInBetween($node, $newNode);
                    break;
                }
                $node = $node->getNext();
            }
        }
    }

    /**
     * @param Node $node
     * @param Node $nextNode
     * @param Node $newNode
     * @return bool
     */
    private function isInBetween(Node $node, Node $nextNode, Node $newNode): bool
    {
        if ($this->sortOrder === self::ORDER_ASC) {
            return $newNode->compare($nextNode) < 0 && $newNode->compare($node) >= 0;
        } else {
            return $newNode->compare($nextNode) >= 0 && $newNode->compare($node) < 0;
        }
    }

    /**
     * @param Node $node
     * @param Node $newNode
     * @return void
     */
    private function insertInBetween(Node $node, Node $newNode): void
    {
        $newNode->setNext($node->getNext());
        $node->setNext($newNode);
    }

    /**
     * @return int|string|null
     */
    public function first(): null|int|string
    {
        if ($this->isEmpty()) {
            return null;
        }
        /** @psalm-suppress PossiblyNullReference */
        $value = $this->head->getValue();
        return $value;
    }

    /**
     * @return int|string|null
     */
    public function last(): null|int|string
    {
        if ($this->isEmpty()) {
            return null;
        }

        /** @psalm-suppress PossiblyNullReference */
        $value = $this->tail->getValue();
        return $value;
    }

    public function get(int $index): null|int|string
    {
        if ($index < 0 || $index > $this->length) {
            return null;
        }
        if ($this->isEmpty()) {
            return null;
        }
        $counter = 0;
        $node = $this->head;
        while ($node !== null && $index !== $counter) {
            $node = $node->getNext();
            $counter++;
        }
        return $node !== null ? $node->getValue() : null;
    }

    /**
     * @param int|string $value
     * @return false|int|string
     */
    public function contains(int|string $value): false|int|string
    {
        $index = 0;
        $node = $this->head;
        if ($node) {
            while ($node !== null) {
                if ($value === $node->getValue()) {
                    return $index;
                }
                $node = $node->getNext();
                $index++;
            }
        }
        return false;
    }

    /**
     * @param int $index
     * @return void
     */
    public function removeFrom(int $index): void
    {
        if ($this->isEmpty()) {
            return;
        }

        if ($index < 0 || $index > $this->length) {
            return;
        }

        $counter = 0;
        $node = $this->head;
        $prev = null;
        $this->length--;

        if ($index === 0) {
            /** @psalm-suppress PossiblyNullReference head */
            $this->head = $this->head->getNext();
            return;
        }

        while ($index !== $counter) {
            $prev = $node;
            $node = $node ? $node->getNext() : null;
            $counter++;
        }

        if ($prev !== null && $node !== null) {
            $prev->setNext($node->getNext());

            if ($index === $this->length) {
                $this->tail = $prev;
            }
        }
    }

    /**
     * @return int|string|null
     */
    public function shift(): null|int|string
    {
        if ($this->isEmpty()) {
            return null;
        }

        /** @var Node $head */
        $head = $this->head;
        $this->head = $head->getNext();
        $this->length--;
        $this->rewind();

        return $head->getValue();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        if ($this->isEmpty()) {
            return [];
        }
        $values = [];
        $node = $this->head;
        while ($node !== null) {
            $values[] = $node->getValue();
            $node = $node->getNext();
        }
        return $values;
    }

    /**
     * @return int|string|null
     */
    public function current(): null|int|string
    {
        if ($this->isEmpty()) {
            return null;
        }

        if ($this->current === null) {
            return null;
        }

        return $this->current->getValue();
    }

    /**
     * @return int|string|null
     */
    public function next(): null|int|string
    {
        if ($this->isEmpty()) {
            return null;
        }

        if ($this->current === null) {
            return null;
        }

        $this->current = $this->current->getNext();

        if ($this->current === null) {
            return null;
        }

        return $this->current->getValue();
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        if ($this->isEmpty()) {
            return;
        }
        $this->current = $this->head;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->length;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->head === null ? true : false;
    }


}