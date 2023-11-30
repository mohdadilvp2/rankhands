<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\PokerHand;

/**
 * Class AbstractHandType
 *
 * @package Adil\RankHands\HandTypes
 */
abstract class AbstractHandType
{
    /**
     * The poker hand instance.
     *
     * @var PokerHand
     */
    protected PokerHand $pokerHand;

    /**
     * AbstractHandType constructor.
     *
     * @param PokerHand $pokerHand The poker hand instance.
     */
    public function __construct(PokerHand $pokerHand)
    {
        $this->pokerHand = $pokerHand;
    }

    /**
     * Check if the hand type matches the current poker hand.
     *
     * @return bool
     */
    abstract public function isMatch(): bool;

    /**
     * Get the base rank associated with the hand type.
     *
     * @return int
     */
    abstract public function getBaseRank(): int;

    /**
     * Get the string representation of the hand type.
     *
     * @return string
     */
    abstract public function getHandType(): string;
}
