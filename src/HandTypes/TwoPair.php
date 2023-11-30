<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class TwoPair
 *
 * Represents the Two Pair poker hand type.
 *
 * @package Adil\RankHands\HandTypes
 */
class TwoPair extends AbstractHandType
{
    /**
     * Check if the poker hand matches the Two Pair criteria.
     *
     * @return bool Returns true if the hand is Two Pair, false otherwise.
     */
    public function isMatch(): bool
    {
        $cardRanks = $this->pokerHand->getCardRanks();
        $occurrencesCount = array_values(array_count_values($cardRanks));
        sort($occurrencesCount);
        if (count($occurrencesCount) === 3 && $occurrencesCount == [1, 2, 2]) {
            return true;
        }
        return false;
    }

    /**
     * Get the base rank associated with the Two Pair hand type.
     *
     * @return int The base rank for Two Pair.
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::TwoPair];
    }

    /**
     * Get the string representation of the hand type (Two Pair).
     *
     * @return string The hand type as a string.
     */
    public function getHandType(): string
    {
        return PokerHandConstants::TwoPair;
    }
}
