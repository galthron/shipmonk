<?php

namespace tests;

use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;
use ShipMonk\Node;
use ShipMonk\SortedLinkedList;

/**
 * @psalm-suppress UnusedClass
 */
class SortedLinkedListTest extends TestCase
{
    private function createIntSortedLinkedList(): SortedLinkedList
    {
        $sortedLL = new SortedLinkedList('integer');
        $sortedLL->insert(222);
        $sortedLL->insert(111);
        $sortedLL->insert(444);
        $sortedLL->insert(333);
        $sortedLL->insert(555);

        return $sortedLL;
    }

    public function testListTypeInvalid(): void
    {
        self::expectExceptionMessage('Incorect list type. Only integer & string possible');
        new SortedLinkedList('boolean');
    }

    public function testListTypeInteger(): void
    {
        $sortedLL = new SortedLinkedList('integer');
        self::assertInstanceOf(SortedLinkedList::class, $sortedLL);
    }

    public function testListTypeString(): void
    {
        $sortedLL = new SortedLinkedList('string');
        self::assertInstanceOf(SortedLinkedList::class, $sortedLL);
    }

    public function testListIncorrectSort(): void
    {
        self::expectExceptionMessage('Incorect list sort order. Only asc & desc possible');
        new SortedLinkedList('string', 'boom');
    }

    public function testListCorrectSortAsc(): void
    {
        $sortedLL = new SortedLinkedList('string', SortedLinkedList::ORDER_ASC);
        self::assertInstanceOf(SortedLinkedList::class, $sortedLL);
    }

    public function testListCorrectSortDesc(): void
    {
        $sortedLL = new SortedLinkedList('string', SortedLinkedList::ORDER_DESC);
        self::assertInstanceOf(SortedLinkedList::class, $sortedLL);
    }

    public function testInsertWrongTypeValueToIntegerList(): void
    {
        self::expectExceptionMessage('Incorect value type. Only integer possible');
        $sortedLL = new SortedLinkedList('integer');
        $sortedLL->insert('heythere');
    }

    public function testInsertWrongTypeValueToStringList(): void
    {
        self::expectExceptionMessage('Incorect value type. Only string possible');
        $sortedLL = new SortedLinkedList('string');
        $sortedLL->insert(12345);
    }

    public function testInsertWrongBoolTypeValueToStringList(): void
    {
        self::expectExceptionMessage('Incorect value type. Only string possible');
        $sortedLL = new SortedLinkedList('string');
        /**
         * @psalm-suppress InvalidScalarArgument
         */
        $sortedLL->insert(true);
    }

    public function testInsertIntListAsc(): void
    {
        $sortedLL = new SortedLinkedList('integer');

        $sortedLL->insert(666);
        $sortedLL->insert(333);
        $sortedLL->insert(111);
        $sortedLL->insert(222);
        $sortedLL->insert(0);
        $sortedLL->insert(55555);
        $sortedLL->insert(444);
        $sortedLL->insert(-10);
        $sortedLL->insert(111);
        self::assertEquals([-10, 0, 111, 111, 222, 333, 444, 666, 55555], $sortedLL->toArray());
    }

    public function testInsertStringListAsc(): void
    {
        $sortedLL = new SortedLinkedList('string');

        $sortedLL->insert('aaaa');
        $sortedLL->insert('baaa');
        $sortedLL->insert('Baaa');
        $sortedLL->insert('aąaa');
        $sortedLL->insert('aaaaaa');
        $sortedLL->insert('*aaa');
        $sortedLL->insert('ęałaa');
        $sortedLL->insert('eąłaa');
        self::assertEquals(['*aaa', 'aaaa', 'aaaaaa', 'aąaa', 'baaa', 'Baaa', 'eąłaa', 'ęałaa'], $sortedLL->toArray());
    }

    public function testInsertStringListDesc(): void
    {
        $sortedLL = new SortedLinkedList('string', SortedLinkedList::ORDER_DESC);

        $sortedLL->insert('abaa');
        $sortedLL->insert('aaaa');
        $sortedLL->insert('aaca');
        $sortedLL->insert('aaab');
        $sortedLL->insert('abca');

        self::assertEquals(['abca', 'abaa', 'aaca', 'aaab', 'aaaa'], $sortedLL->toArray());
    }

    public function testInsertIntListDesc(): void
    {
        $sortedLL = new SortedLinkedList('integer', SortedLinkedList::ORDER_DESC);

        $sortedLL->insert(666);
        $sortedLL->insert(333);
        $sortedLL->insert(111);
        $sortedLL->insert(222);
        $sortedLL->insert(555);
        $sortedLL->insert(444);
        $sortedLL->insert(111);
        self::assertEquals([666, 555, 444, 333, 222, 111, 111], $sortedLL->toArray());
    }

    public function testCountEmptyIntList(): void
    {
        $sortedLL = new SortedLinkedList('integer');
        self::assertEquals(0, $sortedLL->count());
    }

    public function testCountIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        self::assertEquals(5, $sortedLL->count());
    }

    public function testGetIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();

        self::assertEquals(333, $sortedLL->get(2));
    }

    public function testFirstIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        self::assertEquals(111, $sortedLL->first());
    }

    public function testGetLastIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        self::assertEquals(555, $sortedLL->get(4));
    }

    public function testNotContainsIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        self::assertEquals(false, $sortedLL->contains(334));
    }

    public function testContainsIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        self::assertEquals(2, $sortedLL->contains(333));
    }

    public function testRemoveFromIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        $sortedLL->removeFrom(2);

        self::assertEquals(444, $sortedLL->get(2));
        self::assertEquals(4, $sortedLL->count());
    }

    public function testRemoveFirstFromEmptyList(): void
    {
        $sortedLL = new SortedLinkedList('integer');
        $sortedLL->removeFrom(0);
        self::assertTrue($sortedLL->isEmpty());
    }

    public function testRemoveFirstFromIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        $sortedLL->removeFrom(0);

        self::assertEquals(222, $sortedLL->first());
        self::assertEquals(4, $sortedLL->count());
    }

    public function testRemoveNotExistingFromEmptyList(): void
    {
        $sortedLL = new SortedLinkedList('integer');
        $sortedLL->removeFrom(12);
        self::assertTrue($sortedLL->isEmpty());
    }

    public function testRemoveLastFromIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();
        $sortedLL->removeFrom(3);
        self::assertEquals(555, $sortedLL->last());
        self::assertEquals(4, $sortedLL->count());
    }

    public function testShiftIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();

        self::assertEquals(111, $sortedLL->shift());
        self::assertEquals(222, $sortedLL->shift());
        self::assertEquals(333, $sortedLL->shift());
        self::assertEquals(444, $sortedLL->shift());
        self::assertEquals(555, $sortedLL->shift());
        self::assertEquals(null, $sortedLL->shift());
        self::assertEquals(0, $sortedLL->count());
    }

    public function testToArrayIntList(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();

        self::assertEquals([111, 222, 333, 444, 555], $sortedLL->toArray());
    }

    public function testIsEmptyTrue(): void
    {
        $sortedLL = new SortedLinkedList('integer');
        self::assertTrue($sortedLL->isEmpty());

        $sortedLL->insert(111);
        $sortedLL->insert(333);
        $sortedLL->insert(222);

        $sortedLL->shift();
        $sortedLL->shift();
        $sortedLL->shift();

        self::assertTrue($sortedLL->isEmpty());
    }

    public function testIsEmptyFalse(): void
    {
        $sortedLL = new SortedLinkedList('integer');

        $sortedLL->insert(111);
        $sortedLL->insert(333);
        $sortedLL->insert(222);

        $sortedLL->shift();
        $sortedLL->shift();

        self::assertFalse($sortedLL->isEmpty());
    }

    public function testCurrent(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();

        self::assertEquals(111, $sortedLL->current());
        self::assertEquals(111, $sortedLL->shift());
        self::assertEquals(222, $sortedLL->current());
    }

    public function testNext(): void
    {
        $sortedLL = $this->createIntSortedLinkedList();

        self::assertEquals(111, $sortedLL->current());
        self::assertEquals(222, $sortedLL->next());
        self::assertEquals(222, $sortedLL->current());
        self::assertEquals(333, $sortedLL->next());
        self::assertEquals(333, $sortedLL->current());
        self::assertEquals(444, $sortedLL->next());
        self::assertEquals(444, $sortedLL->current());
        self::assertEquals(555, $sortedLL->next());
        self::assertEquals(555, $sortedLL->current());
        self::assertEquals(null, $sortedLL->next());
    }

    public function testRewind(): void
    {
        $sortedLL = new SortedLinkedList('integer');
        $sortedLL->insert(111);
        $sortedLL->insert(333);
        $sortedLL->insert(222);

        self::assertEquals(222, $sortedLL->next());
        self::assertEquals(333, $sortedLL->next());
        self::assertEquals(333, $sortedLL->current());

        $sortedLL->rewind();
        self::assertEquals(111, $sortedLL->current());
    }
}