<?php


use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;
use ShipMonk\Node;
use ShipMonk\SortedLinkedList;

/**
 * @psalm-suppress UnusedClass
 */
class NodeTest extends TestCase
{
//    public function testCompareEqualInt(): void
//    {
//        $node = new Node(100);
//        $node1 = new Node(100);
//
//        $this->assertEquals(0, $node->compare($node1));
//    }
//
//    public function testCompareGreaterInt():void
//    {
//        $node = new Node(-99);
//        $node1 = new Node(-100);
//
//        $this->assertEquals(1, $node->compare($node1));
//    }
//
//    public function testCompareLesserInt():void
//    {
//        $node = new Node(100);
//        $node1 = new Node(101);
//
//        $this->assertEquals(-1, $node->compare($node1));
//    }
//
//    public function testCompareNullNodeInt():void
//    {
//        $node = new Node(-1);
//        $node1 = null;
//
//        $this->assertEquals(1, $node->compare($node1));
//    }
//
//    public function testCompareEqualString(): void
//    {
//        $node = new Node('aaaa');
//        $node1 = new Node('aaaa');
//
//        $this->assertEquals(0, $node->compare($node1));
//    }

    public function testCompareGreaterString():void
    {
        $node = new Node('baaa');
        $node1 = new Node('aaaa');

        $this->assertEquals(1, $node->compare($node1));
    }

////    public function testCompareLesserString():void
////    {
////        $node = new Node('abaaa');
////        $node1 = new Node('1aa');
////
////        $this->assertEquals(-1, $node->compare($node1));
////    }
////
////    public function testCompareNullNodeString():void
////    {
////        $node = new Node('-12123ds');
////        $node1 = null;
////
////        $this->assertEquals(1, $node->compare($node1));
////    }
}