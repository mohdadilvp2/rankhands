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

        $evaluator = new HandEvaluator('invalid');
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

        $expectedOut = implode(PHP_EOL, array_map('trim', explode(PHP_EOL, "
        A♦ K♦ Q♦ J♦ 10♦
        8♣ 7♣ 6♣ 5♣ 4♣
        J♥ J♦ J♠ J♣ 7♦
        10♥ 10♦ 10♠ 9♣ 9♦
        10♥ 10♣ 10♦ 8♥ 8♣
        4♠ J♠ 8♠ 2♠ 9♠
        9♣ 8♦ 7♠ 6♦ 5♥
        7♣ 7♦ 7♠ K♣ 3♦
        9♣ 9♥ 2♣ 2♦ J♣
        4♣ 4♠ 3♣ 3♦ Q♣
        A♥ A♦ K♣ 4♠ 7♥
        A♥ A♦ 8♣ 4♠ 7♥
        3♦ J♣ 8♠ 4♥ 2♠
        ")));

        $evaluator = new HandEvaluator($input);
        $out = $evaluator->rankHands();

        $this->assertEquals(trim($expectedOut), trim($out));
    }
}
