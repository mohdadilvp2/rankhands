<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class StraightFlush
 *
 * Represents the Straight Flush poker hand type.
 *
 * @package Adil\RankHands\HandTypes
 */
class StraightFlush extends AbstractHandType
{
    use HandMatchingTrait;

    /**
     * Check if the poker hand matches the Straight Flush criteria.
     *
     * @return bool Returns true if the hand is a Straight Flush, false otherwise.
     */
    public function isMatch(): bool
    {
        $suits = $this->pokerHand->getSuits();
        $cardRanksInNumbers = $this->pokerHand->getCardRanksInNumbers();
        return $this->isFlush($suits) && $this->isStraight($cardRanksInNumbers);
    }

    /**
     * Get the base rank associated with the Straight Flush hand type.
     *
     * @return int The base rank for Straight Flush.
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::StraightFlush];
    }

    /**
     * Get the string representation of the hand type (Straight Flush).
     *
     * @return string The hand type as a string.
     */
    public function getHandType(): string
    {
        return PokerHandConstants::StraightFlush;
    }
}
