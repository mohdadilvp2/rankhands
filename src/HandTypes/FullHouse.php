<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class FullHouse
 *
 * Represents the Full House hand type in poker.
 *
 * @package Adil\RankHands\HandTypes
 */
class FullHouse extends AbstractHandType
{
    use HandMatchingTrait;

    /**
     * Check if the current poker hand matches the Full House hand type.
     *
     * @return bool
     */
    public function isMatch(): bool
    {
        $cardRanks = $this->pokerHand->getCardRanks();
        $occurrencesCount = array_values(array_count_values($cardRanks));
        sort($occurrencesCount);
        if (count($occurrencesCount) === 2 && $occurrencesCount === [2, 3]) {
            return true;
        }
        return false;
    }

    /**
     * Get the base rank associated with the Full House hand type.
     *
     * @return int
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::FullHouse];
    }

    /**
     * Get the string representation of the Full House hand type.
     *
     * @return string
     */
    public function getHandType(): string
    {
        return PokerHandConstants::FullHouse;
    }
}
