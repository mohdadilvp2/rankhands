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
    private ?int $firstHighestCardRank = null;
    private ?int $secondHighestCardRank = null;
    private ?int $thirdHighestCardRank = null;
    private ?int $fourthHighestCardRank = null;
    private ?int $fifthHighestCardRank = null;

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
     * Get the highest card ranks.
     *
     * @return array
     */
    public function getHighestCardRanks(): array
    {
        $ranks = [
            'first_highest_card_rank' => $this->firstHighestCardRank,
            'second_highest_card_rank' => $this->secondHighestCardRank,
            'third_highest_card_rank' => $this->thirdHighestCardRank,
            'fourth_highest_card_rank' => $this->fourthHighestCardRank,
            'fifth_highest_card_rank' => $this->fifthHighestCardRank,
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
     * Set the highest card ranks based on the hand type.
     */
    private function setHighestCardRanks(): void
    {
        $cardRanks = $this->getCardRanksInNumbers();
        rsort($cardRanks);
        $handType = $this->handType;
        $cardOccurrences = array_count_values($cardRanks);

        switch ($handType) {
            case PokerHandConstants::StraightFlush:
                $this->firstHighestCardRank = $cardRanks[0];
                break;
            case PokerHandConstants::FourOfAKind:
                $this->firstHighestCardRank = array_search(4, $cardOccurrences);
                $this->secondHighestCardRank = array_search(1, $cardOccurrences);
                break;
            case PokerHandConstants::FullHouse:
                $this->firstHighestCardRank = array_search(3, $cardOccurrences);
                $this->secondHighestCardRank = array_search(2, $cardOccurrences);
                break;
            case PokerHandConstants::Straight:
                $this->firstHighestCardRank = $cardRanks[0];
                break;
            case PokerHandConstants::ThreeOfAKind:
                $this->firstHighestCardRank = array_search(3, $cardOccurrences);
                $restOfTheCardRanks = array_values(array_diff($cardRanks, [$this->firstHighestCardRank, $this->firstHighestCardRank, $this->firstHighestCardRank]));
                $this->secondHighestCardRank = $restOfTheCardRanks[0];
                $this->thirdHighestCardRank = $restOfTheCardRanks[1];
                break;
            case PokerHandConstants::TwoPair:
                $cardRanksOccurringTwice = array_keys(array_filter($cardOccurrences, function ($count) {return $count === 2;}));
                rsort($cardRanksOccurringTwice);
                $this->firstHighestCardRank = $cardRanksOccurringTwice[0];
                $this->secondHighestCardRank = $cardRanksOccurringTwice[1];
                $this->thirdHighestCardRank = array_search(1, $cardOccurrences);
                break;
            case PokerHandConstants::Pair:
                $cardRanksOccurringTwice = array_keys(array_filter($cardOccurrences, function ($count) { return $count === 2;}));
                $restOfTheCardRanks = array_values(array_diff($cardRanks, [$cardRanksOccurringTwice[0], $cardRanksOccurringTwice[0]]));
                rsort($restOfTheCardRanks);
                $this->firstHighestCardRank = $cardRanksOccurringTwice[0];
                $this->secondHighestCardRank = $restOfTheCardRanks[0];
                $this->thirdHighestCardRank = $restOfTheCardRanks[1];
                $this->fourthHighestCardRank = $restOfTheCardRanks[2];
                break;
            case PokerHandConstants::Flush:
            case PokerHandConstants::HighCard:
                $this->firstHighestCardRank = $cardRanks[0];
                $this->secondHighestCardRank = $cardRanks[1];
                $this->thirdHighestCardRank = $cardRanks[2];
                $this->fourthHighestCardRank = $cardRanks[3];
                $this->fifthHighestCardRank = $cardRanks[4];
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
     * Get the card ranks in numbers.
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
