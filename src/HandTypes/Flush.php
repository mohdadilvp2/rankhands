<?php

namespace Adil\RankHands\HandTypes;

use Adil\RankHands\Constants\PokerHandConstants;

/**
 * Class Flush
 *
 * Represents the Flush hand type in poker.
 *
 * @package Adil\RankHands\HandTypes
 */
class Flush extends AbstractHandType
{
    use HandMatchingTrait;

    /**
     * Check if the current poker hand matches the Flush hand type.
     *
     * @return bool
     */
    public function isMatch(): bool
    {
        $suits = $this->pokerHand->getSuits();
        return $this->isFlush($suits);
    }

    /**
     * Get the base rank associated with the Flush hand type.
     *
     * @return int
     */
    public function getBaseRank(): int
    {
        return PokerHandConstants::BASE_RANK_ARRAY[PokerHandConstants::Flush];
    }

    /**
     * Get the string representation of the Flush hand type.
     *
     * @return string
     */
    public function getHandType(): string
    {
        return PokerHandConstants::Flush;
    }
}
