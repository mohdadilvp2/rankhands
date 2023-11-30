<?php
/**
 * @file
 * run.php.
 */
use \Adil\RankHands\HandEvaluator;
$loader = require 'vendor/autoload.php';
$loader->register();


// Check if the command line argument is provided
if (isset($argv[1])) {
    // Get the file path from the command line argument
    $filePath = $argv[1];

    // Check if the file exists
    if (file_exists($filePath)) {
        // Read the content of the file
        $handString = file_get_contents($filePath);

        // Create an instance of HandEvaluator with the input data
        $handEvaluator = new HandEvaluator($handString);

        // Rank hands and output the result
        echo $handEvaluator->rankHands();
    } else {
        echo "Error: The specified file does not exist." . PHP_EOL;
    }
} else {
    echo "Error: Please provide the path to the file containing input data as a command line argument." . PHP_EOL;
}