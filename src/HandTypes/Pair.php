<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class Pair
 *
 * Represents the Pair poker hand type.
 *
 * @package Adil\RankHands\HandTypes
 */
class Pair extends AbstractHandType
{
    /**
     * Check if the poker hand matches the Pair criteria.
     *
     * @return bool Returns true if the hand contains a pair, false otherwise.
     */
    public function isMatch(): bool
    {
        $cardRanks = $this->pokerHand->getCardRanks();
        $occurrencesCount = array_values(array_count_values($cardRanks));
        if (count($occurrencesCount) === 4 && in_array(2, $occurrencesCount)) {
            return true;
        }
        return false;
    }

    /**
     * Get the base rank associated with the Pair hand type.
     *
     * @return int The base rank for Pair.
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::Pair];
    }

    /**
     * Get the string representation of the hand type (Pair).
     *
     * @return string The hand type as a string.
     */
    public function getHandType(): string
    {
        return PokerHandConstants::Pair;
    }
}
