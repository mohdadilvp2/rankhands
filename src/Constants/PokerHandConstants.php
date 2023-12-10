<?php

namespace Adil\RankHands\Constants;

/**
 * Class PokerHandConstants
 *
 * @package Adil\RankHands\Constants
 */
class PokerHandConstants
{
    /**
     * Hand types constants.
     */
    public const RoyalFlush = 'RoyalFlush';
    public const StraightFlush = 'StraightFlush';
    public const FourOfAKind = 'FourOfAKind';
    public const FullHouse = 'FullHouse';
    public const Flush = 'Flush';
    public const Straight = 'Straight';
    public const ThreeOfAKind = 'ThreeOfAKind';
    public const TwoPair = 'TwoPair';
    public const Pair = 'Pair';
    public const HighCard = 'HighCard';

    /**
     * Base rank array for each hand type.
     */
    public const BASE_RANK_ARRAY = [
        self::RoyalFlush => 1,
        self::StraightFlush => 2,
        self::FourOfAKind => 3,
        self::FullHouse => 4,
        self::Flush => 5,
        self::Straight => 6,
        self::ThreeOfAKind => 7,
        self::TwoPair => 8,
        self::Pair => 9,
        self::HighCard => 10
    ];

    /**
     * Card order mapping.
     */
    public const CARD_ORDER = [
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    ];

    /**
     * Symbol to string mapping for cards.
     */
    public const SYMBOL_TO_STRING = [
        '♥' => 'H',
        '♠' => 'S',
        '♣' => 'C',
        '♦' => 'D'
    ];
}
