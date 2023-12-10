<?php

namespace Adil\RankHands;

use Adil\RankHands\Constants\PokerHandConstants;
use Adil\RankHands\HandTypes\RoyalFlush;
use Adil\RankHands\HandTypes\StraightFlush;
use Adil\RankHands\HandTypes\FourOfAKind;
use Adil\RankHands\HandTypes\FullHouse;
use Adil\RankHands\HandTypes\Flush;
use Adil\RankHands\HandTypes\Straight;
use Adil\RankHands\HandTypes\ThreeOfAKind;
use Adil\RankHands\HandTypes\TwoPair;
use Adil\RankHands\HandTypes\Pair;
use Adil\RankHands\HandTypes\HighCard;

/**
 * Class PokerHand
 *
 * @package Adil\RankHands
 */
class PokerHand
{
    private array $cards;
    private ?int $baseRank = null;
    private ?string $handType = null;
    private ?int $firstHighestCardScore = null;
    private ?int $secondHighestCardScore = null;
    private ?int $thirdHighestCardScore = null;
    private ?int $fourthHighestCardScore = null;
    private ?int $fifthHighestCardScore = null;

    /**
     * PokerHand constructor.
     *
     * @param string $cards
     */
    public function __construct(string $cards)
    {
        $this->cards = explode(" ", $cards);
        $this->calculateBaseRank();
        $this->setHighestCardScores();
    }

    /**
     * Get the highest card scores.
     *
     * @return array
     */
    public function getHighestCardScores(): array
    {
        $ranks = [
            'first_highest_card_score' => $this->firstHighestCardScore,
            'second_highest_card_score' => $this->secondHighestCardScore,
            'third_highest_card_score' => $this->thirdHighestCardScore,
            'fourth_highest_card_score' => $this->fourthHighestCardScore,
            'fifth_highest_card_score' => $this->fifthHighestCardScore,
        ];
        return $ranks;
    }

    /**
     * Get the cards in the hand.
     *
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Get the base rank of the hand.
     *
     * @return int|null
     */
    public function getBaseRank(): ?int
    {
        return $this->baseRank;
    }

    /**
     * Get the type of the hand.
     *
     * @return string|null
     */
    public function getHandType(): ?string
    {
        return $this->handType;
    }

    /**
     * Calculate the base rank of the hand.
     */
    private function calculateBaseRank(): void
    {
        $handTypes = [
            RoyalFlush::class,
            StraightFlush::class,
            FourOfAKind::class,
            FullHouse::class,
            Flush::class,
            Straight::class,
            ThreeOfAKind::class,
            TwoPair::class,
            Pair::class,
            HighCard::class,
        ];
        foreach ($handTypes as $handType) {
            $handTypeValidator = new $handType($this);
            if ($handTypeValidator->isMatch()) {
                $this->baseRank = $handTypeValidator->getBaseRank();
                $this->handType = $handTypeValidator->getHandType();
                break;
            }
        }
    }

    /**
     * Set the highest card scores based on the hand type.
     */
    private function setHighestCardScores(): void
    {
        $cardScores = $this->getCardScores();
        rsort($cardScores);
        $handType = $this->handType;
        $cardOccurrences = array_count_values($cardScores);

        switch ($handType) {
            case PokerHandConstants::StraightFlush:
                $this->firstHighestCardScore = $cardScores[0];
                break;
            case PokerHandConstants::FourOfAKind:
                // For Four of a Kind, the highest card is the one occurring four times,
                // and the second highest is the one occurring once
                $this->firstHighestCardScore = array_search(4, $cardOccurrences);
                $this->secondHighestCardScore = array_search(1, $cardOccurrences);
                break;
            case PokerHandConstants::FullHouse:
                // For a Full House, the highest card is the one occurring three times,
                // and the second highest is the one occurring twice
                $this->firstHighestCardScore = array_search(3, $cardOccurrences);
                $this->secondHighestCardScore = array_search(2, $cardOccurrences);
                break;
            case PokerHandConstants::Straight:
                $this->firstHighestCardScore = $cardScores[0];
                break;
            case PokerHandConstants::ThreeOfAKind:
                // For Three of a Kind, the highest card is the one occurring three times,
                // and the second and third highest are the remaining two cards
                $this->firstHighestCardScore = array_search(3, $cardOccurrences);
                $restOfTheCardScores = array_values(array_diff($cardScores, [$this->firstHighestCardScore]));
                rsort($restOfTheCardScores);
                $this->secondHighestCardScore = $restOfTheCardScores[0];
                $this->thirdHighestCardScore = $restOfTheCardScores[1];
                break;
            case PokerHandConstants::TwoPair:
                // For Two Pair, the highest and second highest cards are those occurring twice,
                // and the third highest is the one occurring once
                $cardScoresOccurringTwice = array_keys(array_filter($cardOccurrences, function ($count) {
                    return $count === 2;
                }));
                rsort($cardScoresOccurringTwice);
                $this->firstHighestCardScore = $cardScoresOccurringTwice[0];
                $this->secondHighestCardScore = $cardScoresOccurringTwice[1];
                $this->thirdHighestCardScore = array_search(1, $cardOccurrences);
                break;
            case PokerHandConstants::Pair:
                // For a Pair, the highest card is the one occurring twice,
                // and the second, third, and fourth highest are the remaining three cards
                $this->firstHighestCardScore = array_search(2, $cardOccurrences);
                $restOfTheCardScores = array_values(array_diff($cardScores, [$this->firstHighestCardScore]));
                rsort($restOfTheCardScores);
                $this->secondHighestCardScore = $restOfTheCardScores[0];
                $this->thirdHighestCardScore = $restOfTheCardScores[1];
                $this->fourthHighestCardScore = $restOfTheCardScores[2];
                break;
            case PokerHandConstants::Flush:
            case PokerHandConstants::HighCard:
                $this->firstHighestCardScore = $cardScores[0];
                $this->secondHighestCardScore = $cardScores[1];
                $this->thirdHighestCardScore = $cardScores[2];
                $this->fourthHighestCardScore = $cardScores[3];
                $this->fifthHighestCardScore = $cardScores[4];
                break;
        }
    }

    /**
     * Get the card ranks.
     *
     * @return array
     */
    public function getCardRanks(): array
    {
        return array_map(function ($card) {
            return substr($card, 0, -1);
        }, $this->cards);
    }

    /**
     * Get the card scores.
     *
     * @return array
     */
    public function getCardScores(): array
    {
        return array_map(function ($card) {
            $cardRank = substr($card, 0, -1);
            return PokerHandConstants::CARD_ORDER[$cardRank];
        }, $this->cards);
    }

    /**
     * Get the suits of the cards.
     *
     * @return array
     */
    public function getSuits(): array
    {
        return array_map(function ($card) {
            return substr($card, -1);
        }, $this->cards);
    }
}
