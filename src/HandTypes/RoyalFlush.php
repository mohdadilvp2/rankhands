<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class RoyalFlush
 *
 * Represents the Royal Flush poker hand type.
 *
 * @package Adil\RankHands\HandTypes
 */
class RoyalFlush extends AbstractHandType
{
    use HandMatchingTrait;

    /**
     * Check if the poker hand matches the Royal Flush criteria.
     *
     * @return bool Returns true if the hand is a Royal Flush, false otherwise.
     */
    public function isMatch(): bool
    {
        $expectedRanks = ['10', 'J', 'Q', 'K', 'A'];
        $cardRanks = $this->pokerHand->getCardRanks();
        $suits = $this->pokerHand->getSuits();
        return $this->containsRanks($expectedRanks, $cardRanks) && $this->isFlush($suits);
    }

    /**
     * Get the base rank associated with the Royal Flush hand type.
     *
     * @return int The base rank for Royal Flush.
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::RoyalFlush];
    }

    /**
     * Get the string representation of the hand type (Royal Flush).
     *
     * @return string The hand type as a string.
     */
    public function getHandType(): string
    {
        return PokerHandConstants::RoyalFlush;
    }
}
