<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class Straight
 *
 * Represents the Straight poker hand type.
 *
 * @package Adil\RankHands\HandTypes
 */
class Straight extends AbstractHandType
{
    use HandMatchingTrait;

    /**
     * Check if the poker hand matches the Straight criteria.
     *
     * @return bool Returns true if the hand is a Straight, false otherwise.
     */
    public function isMatch(): bool
    {
        $cardRanksInNumbers = $this->pokerHand->getCardRanksInNumbers();
        return $this->isStraight($cardRanksInNumbers);
    }

    /**
     * Get the base rank associated with the Straight hand type.
     *
     * @return int The base rank for Straight.
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::Straight];
    }

    /**
     * Get the string representation of the hand type (Straight).
     *
     * @return string The hand type as a string.
     */
    public function getHandType(): string
    {
        return PokerHandConstants::Straight;
    }
}
