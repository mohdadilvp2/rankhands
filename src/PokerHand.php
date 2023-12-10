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
        $this->setHighestCardRanks();
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
    private function setHighestCardRanks(): void
    {
        $cardRanks = $this->getCardRanksInNumbers();
        rsort($cardRanks);
        $handType = $this->handType;
        $cardOccurrences = array_count_values($cardRanks);

        switch ($handType) {
            case PokerHandConstants::StraightFlush:
                $this->firstHighestCardScore = $cardRanks[0];
                break;
            case PokerHandConstants::FourOfAKind:
                $this->firstHighestCardScore = array_search(4, $cardOccurrences);
                $this->secondHighestCardScore = array_search(1, $cardOccurrences);
                break;
            case PokerHandConstants::FullHouse:
                $this->firstHighestCardScore = array_search(3, $cardOccurrences);
                $this->secondHighestCardScore = array_search(2, $cardOccurrences);
                break;
            case PokerHandConstants::Straight:
                $this->firstHighestCardScore = $cardRanks[0];
                break;
            case PokerHandConstants::ThreeOfAKind:
                $this->firstHighestCardScore = array_search(3, $cardOccurrences);
                $restOfTheCardRanks = array_values(array_diff($cardRanks, [$this->firstHighestCardScore, $this->firstHighestCardScore, $this->firstHighestCardScore]));
                $this->secondHighestCardScore = $restOfTheCardRanks[0];
                $this->thirdHighestCardScore = $restOfTheCardRanks[1];
                break;
            case PokerHandConstants::TwoPair:
                $cardRanksOccurringTwice = array_keys(array_filter($cardOccurrences, function ($count) {return $count === 2;}));
                rsort($cardRanksOccurringTwice);
                $this->firstHighestCardScore = $cardRanksOccurringTwice[0];
                $this->secondHighestCardScore = $cardRanksOccurringTwice[1];
                $this->thirdHighestCardScore = array_search(1, $cardOccurrences);
                break;
            case PokerHandConstants::Pair:
                $cardRanksOccurringTwice = array_keys(array_filter($cardOccurrences, function ($count) { return $count === 2;}));
                $restOfTheCardRanks = array_values(array_diff($cardRanks, [$cardRanksOccurringTwice[0], $cardRanksOccurringTwice[0]]));
                rsort($restOfTheCardRanks);
                $this->firstHighestCardScore = $cardRanksOccurringTwice[0];
                $this->secondHighestCardScore = $restOfTheCardRanks[0];
                $this->thirdHighestCardScore = $restOfTheCardRanks[1];
                $this->fourthHighestCardScore = $restOfTheCardRanks[2];
                break;
            case PokerHandConstants::Flush:
            case PokerHandConstants::HighCard:
                $this->firstHighestCardScore = $cardRanks[0];
                $this->secondHighestCardScore = $cardRanks[1];
                $this->thirdHighestCardScore = $cardRanks[2];
                $this->fourthHighestCardScore = $cardRanks[3];
                $this->fifthHighestCardScore = $cardRanks[4];
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
     * Get the card score in numbers.
     *
     * @return array
     */
    public function getCardRanksInNumbers(): array
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
