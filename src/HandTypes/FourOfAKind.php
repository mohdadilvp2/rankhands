<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class FourOfAKind
 *
 * Represents the Four of a Kind hand type in poker.
 *
 * @package Adil\RankHands\HandTypes
 */
class FourOfAKind extends AbstractHandType
{
    use HandMatchingTrait;

    /**
     * Check if the current poker hand matches the Four of a Kind hand type.
     *
     * @return bool
     */
    public function isMatch(): bool
    {
        return $this->containsNOfAKind(4, $this->pokerHand->getCardRanks());
    }

    /**
     * Get the base rank associated with the Four of a Kind hand type.
     *
     * @return int
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::FourOfAKind];
    }

    /**
     * Get the string representation of the Four of a Kind hand type.
     *
     * @return string
     */
    public function getHandType(): string
    {
        return PokerHandConstants::FourOfAKind;
    }
}
