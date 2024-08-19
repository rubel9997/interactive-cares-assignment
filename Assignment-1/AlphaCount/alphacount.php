#! /usr/bin/env php

<?php

// alpha count CLI app

// Function to count alpha in the sentence
function alphaCount($sentence) {
    // Remove non-alphabet characters and calculate the length of the cleaned sentence
    $cleanedSentence = preg_replace('/[^a-zA-Z]/', '', $sentence);
    //var_dump($cleanedSentence);
    $count = strlen($cleanedSentence);

    //  $count = 0;
    // for($i=0; $i < strlen($sentence); $i++){
    //     if (ctype_alpha($sentence[$i])) {
    //         $count++;
    //     }
    // }

    printf($count);
}

if ($argc !== 2) {
    printf("Give a sentence for alphacount like 'PHP is Love!'\n");
    exit(1);
}

$sentence = $argv[1];

// var_dump($argc);

// Call the function to count alpha
$alphabetCount = alphaCount($sentence);
