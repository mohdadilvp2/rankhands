<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class ThreeOfAKind
 *
 * Represents the Three of a Kind poker hand type.
 *
 * @package Adil\RankHands\HandTypes
 */
class ThreeOfAKind extends AbstractHandType
{
    use HandMatchingTrait;

    /**
     * Check if the poker hand matches the Three of a Kind criteria.
     *
     * @return bool Returns true if the hand is Three of a Kind, false otherwise.
     */
    public function isMatch(): bool
    {
        return $this->containsNOfAKind(3, $this->pokerHand->getCardRanks());
    }

    /**
     * Get the base rank associated with the Three of a Kind hand type.
     *
     * @return int The base rank for Three of a Kind.
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::ThreeOfAKind];
    }

    /**
     * Get the string representation of the hand type (Three of a Kind).
     *
     * @return string The hand type as a string.
     */
    public function getHandType(): string
    {
        return PokerHandConstants::ThreeOfAKind;
    }
}
