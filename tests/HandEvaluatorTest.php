<?php

namespace Adil\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Adil\RankHands\HandEvaluator;

/**
 * Test PokerHand methods.
 */
class HandEvaluatorTest extends TestCase
{
    public function testValidationError(): void
    {
        $this->expectException(Exception::class);

        $evaluator = new HandEvaluator('----');
        $evaluator->rankHands();
    }

    public function testValidCase(): void
    {
        $input = '10♥ 10♦ 10♠ 9♣ 9♦
        4♠ J♠ 8♠ 2♠ 9♠
        3♦ J♣ 8♠ 4♥ 2♠
        9♣ 9♥ 2♣ 2♦ J♣
        7♣ 7♦ 7♠ K♣ 3♦
        10♥ 10♣ 10♦ 8♥ 8♣
        A♥ A♦ 8♣ 4♠ 7♥
        J♥ J♦ J♠ J♣ 7♦
        A♥ A♦ K♣ 4♠ 7♥
        8♣ 7♣ 6♣ 5♣ 4♣
        9♣ 8♦ 7♠ 6♦ 5♥
        4♣ 4♠ 3♣ 3♦ Q♣
        A♦ K♦ Q♦ J♦ 10♦';

        $expectedOut = trim("A♦ K♦ Q♦ J♦ 10♦\n8♣ 7♣ 6♣ 5♣ 4♣\nJ♥ J♦ J♠ J♣ 7♦\n10♥ 10♦ 10♠ 9♣ 9♦\n10♥ 10♣ 10♦ 8♥ 8♣\n4♠ J♠ 8♠ 2♠ 9♠\n9♣ 8♦ 7♠ 6♦ 5♥\n7♣ 7♦ 7♠ K♣ 3♦\n9♣ 9♥ 2♣ 2♦ J♣\n4♣ 4♠ 3♣ 3♦ Q♣\nA♥ A♦ K♣ 4♠ 7♥\nA♥ A♦ 8♣ 4♠ 7♥\n3♦ J♣ 8♠ 4♥ 2♠");

        $evaluator = new HandEvaluator($input);
        $out = $evaluator->rankHands();

        $this->assertEquals(trim($expectedOut), trim($out));
    }
}
