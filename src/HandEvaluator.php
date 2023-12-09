<?php

namespace Adil\RankHands;

use Adil\RankHands\Constants\PokerHandConstants;
use Exception;

/**
 * Class HandEvaluator
 *
 * @package Adil\RankHands
 */
class HandEvaluator
{
    /**
     * @var string
     */
    private string $handString;

    /**
     * HandEvaluator constructor.
     *
     * @param string $handString
     */
    public function __construct(string $handString)
    {
        $this->handString = $handString;
    }

    /**
     * Rank hands based on the given input string.
     *
     * @return string
     */
    public function rankHands(): string
    {
        $this->validateHandString();
        $hands = $this->getHandsArray();
        $hands = $this->replaceSymbolsWithCharacter($hands);
        $hands = $this->orderHands($hands);
        return implode(PHP_EOL, $this->replaceCharacterWithSymbols($hands));
    }

    /**
     * Get an array of hands from the input string.
     *
     * @return array
     */
    private function getHandsArray(): array
    {
        return explode(PHP_EOL, trim($this->handString));
    }

    /**
     * Replace characters with symbols in the given hands array.
     *
     * @param array $hands
     * @return array
     */
    private function replaceCharacterWithSymbols(array $hands): array
    {
        return $this->replaceSymbols($hands, array_flip(PokerHandConstants::SYMBOL_TO_STRING));
    }

    /**
     * Replace symbols with characters in the given hands array.
     *
     * @param array $hands
     * @return array
     */
    private function replaceSymbolsWithCharacter(array $hands): array
    {
        return $this->replaceSymbols($hands, PokerHandConstants::SYMBOL_TO_STRING);
    }

    /**
     * Replace symbols in the given hands array based on the provided mapping.
     *
     * @param array $hands
     * @param array $mapping
     * @return array
     */
    private function replaceSymbols(array $hands, array $mapping): array
    {
        return array_map(function($hand) use ($mapping){
            return  strtr($hand, $mapping);
        }, $hands);
    }

    /**
     * Order hands based on their ranks.
     *
     * @param array $hands
     * @return array
     */
    private function orderHands(array $hands): array
    {
        // Initialize an array to store hands after ranking
        $handsAfterRanking = [];

        // Iterate through each hand, calculate ranks, and store relevant information
        foreach ($hands as $hand) {
            $pokerHand = new PokerHand(trim($hand));
            $handsAfterRanking[] = [
                'hand' => trim($hand),
                'base_rank' => $pokerHand->getBaseRank(),
                'hand_type' => $pokerHand->getHandType(),
                'sencondary_checks' => $pokerHand->getHighestCardRanks()
            ];
        }

        // Use usort to sort hands based on base rank and secondary checks
        usort($handsAfterRanking, function ($a, $b) {
            // Compare base ranks
            $baseRankComparison = $b['base_rank'] <=> $a['base_rank'];
            if ($baseRankComparison !== 0) {
                return $baseRankComparison;
            }

            // If base ranks are equal, compare secondary checks
            $secondaryChecksA = $a['sencondary_checks'];
            $secondaryChecksB = $b['sencondary_checks'];
            foreach (['first', 'second', 'third', 'fourth', 'fifth'] as $ordinal) {
                $cardComparison = $secondaryChecksB[$ordinal . '_highest_card_rank'] <=> $secondaryChecksA[$ordinal . '_highest_card_rank'];
                if ($cardComparison !== 0) {
                    return $cardComparison;
                }
            }

            // If both base ranks and secondary checks are equal, return 0
            return 0;
        });
        // Extract and return the hands from the ordered array
        return array_column($handsAfterRanking, 'hand');
    }

    /**
     * Validates the format of each hand in the input string.
     *
     * @throws Exception If any invalid card count, rank, or suit is found.
     */
    private function validateHandString(): void
    {
        $hands = $this->getHandsArray();
        $hands = $this->replaceSymbolsWithCharacter($hands);

        foreach ($hands as $key => $hand) {
            $cards = explode(" ", trim($hand));

            // Validate card count in the hand
            if (count($cards) != 5) {
                throw new Exception("Invalid card count in the row: " . ($key + 1));
            }

            // Validate card ranks
            $ranks = array_map(function ($card) {
                return substr($card, 0, -1);
            }, $cards);
            $validRanks = array_keys(PokerHandConstants::CARD_ORDER);
            $invalidRanks = array_diff($ranks, $validRanks);

            if (count($invalidRanks) > 0) {
                throw new Exception("Invalid card rank found in the row: " . ($key + 1));
            }

            // Validate card suits
            $validSuits = array_values(PokerHandConstants::SYMBOL_TO_STRING);
            $suits = array_map(function ($card) {
                return substr($card, -1);
            }, $cards);

            $invalidSuits = array_diff($suits, $validSuits);

            if (count($invalidSuits) > 0) {
                throw new Exception("Invalid card suit found in the row: " . ($key + 1));
            }
        }
    }
}
