<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class HighCard
 *
 * Represents the High Card poker hand type.
 *
 * @package Adil\RankHands\HandTypes
 */
class HighCard extends AbstractHandType
{
    /**
     * Check if the poker hand matches the High Card criteria.
     *
     * @return bool Always returns true as High Card is checked last.
     */
    public function isMatch(): bool
    {
        // This will be checked last, so the last rank will be for a high card
        return true;
    }

    /**
     * Get the base rank associated with the High Card hand type.
     *
     * @return int The base rank for High Card.
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::HighCard];
    }

    /**
     * Get the string representation of the hand type (High Card).
     *
     * @return string The hand type as a string.
     */
    public function getHandType(): string
    {
        return PokerHandConstants::HighCard;
    }
}
