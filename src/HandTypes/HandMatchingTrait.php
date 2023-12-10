<?php

namespace Adil\RankHands\HandTypes;

/**
 * Trait HandMatchingTrait
 *
 * A trait providing common methods for matching poker hands based on various criteria.
 *
 * @package Adil\RankHands\HandTypes
 */
trait HandMatchingTrait
{
    /**
     * Check if the given card ranks contain the expected ranks.
     *
     * @param array $expectedRanks
     * @param array $cardRanks
     * @return bool
     */
    private function containsRanks(array $expectedRanks, array $cardRanks): bool
    {
        return count(array_intersect($cardRanks, $expectedRanks)) === count($expectedRanks);
    }

    /**
     * Check if the given suits represent a flush (all suits are the same).
     *
     * @param array $suits
     * @return bool
     */
    private function isFlush(array $suits): bool
    {
        return count(array_unique($suits)) === 1;
    }

    /**
     * Check if the given card score form a straight sequence.
     *
     * @param array $cardScores
     * @return bool
     */
    private function isStraight(array $cardScores): bool
    {
        sort($cardScores);
        return $this->consecutiveNumbers($cardScores);
    }

    /**
     * Check if an array of numbers is consecutive.
     *
     * @param array $numbers
     * @return bool
     */
    private function consecutiveNumbers(array $numbers): bool
    {
        for ($i = 0; $i < count($numbers) - 1; $i++) {
            if ($numbers[$i + 1] - $numbers[$i] !== 1) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if the given card ranks contain exactly N of a kind.
     *
     * @param int $n
     * @param array $cardRanks
     * @return bool
     */
    private function containsNOfAKind(int $n, array $cardRanks): bool
    {
        $occurrences = array_count_values($cardRanks);
        foreach ($occurrences as $rankCount) {
            if ($rankCount === $n) {
                return true;
            }
        }
        return false;
    }
}
