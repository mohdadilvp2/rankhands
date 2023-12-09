<?php
/**
 * @file
 * index.php
 */

use Adil\RankHands\HandEvaluator;

// Autoload dependencies
require 'vendor/autoload.php';

/**
 * Main function to run the poker hands ranking application.
 */
function runPokerHandsApp(array $arguments)
{
    // Check if the command line argument is provided
    if (count($arguments) !== 2) {
        displayError("Please provide the path to the file containing input data as a command line argument.");
        exit(1);
    }

    // Get the file path from the command line argument
    $filePath = $arguments[1];

    // Validate and rank hands
    processFile($filePath);
}

/**
 * Process the file, validate the input, and rank hands.
 *
 * @param string $filePath
 */
function processFile($filePath)
{

    // Check if the file exists
    if (!file_exists($filePath)) {
        displayError("Error: The specified file does not exist.");
        exit(1);
    }

    // Read the content of the file
    $handString = file_get_contents($filePath);

    try {
        // Create an instance of HandEvaluator with the input data
        $handEvaluator = new HandEvaluator($handString);

        // Rank hands and output the result
        echo $handEvaluator->rankHands();
    } catch (Exception $e) {
        displayError("Invalid input data. Error Message: " . $e->getMessage());
        exit(1);
    }
}

/**
 * Display error message and usage information.
 *
 * @param string $errorMessage
 */
function displayError($errorMessage)
{
    echo "Error: $errorMessage" . PHP_EOL;
    echo "Usage: php index.php path/to/input/file.txt" . PHP_EOL;
}

// Run the poker hands application with command line arguments
runPokerHandsApp($argv);
