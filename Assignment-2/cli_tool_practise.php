#! /usr/bin/env php
<?php 

// $argv_0 = $argv[0];
// $argv_1 = isset($argv[1]) ? $argv[1]:null;
// $argv_2 = isset($argv[2]) ? $argv[2]:null;
// $argv_3 = isset($argv[3]) ? $argv[3]:null;

//count the agrument passed from cli.
// var_dump($argc); 

//view the agrument passed from cli.and it's return an array.
// var_dump($argv);



//Guessing game using cli tool.
// $rand_number = rand(1,100);

//var_dump($rand_nu3mber);

// $user_input = (int) readline('Enter a number:');
// var_dump($user_input);

// exit(1);

// while(true){
//     $user_input = (int) readline('Enter a number:');
//     var_dump($user_input);

//     if($user_input > $rand_number){
//         printf("Try a lower number.\n");
//     }
//     else if($user_input < $rand_number){
//         printf("Try a bigger number.\n");
//     }else{
//         printf("Congrats! You guessed it right!");
//         break;
//     }
    
// }







// $argv_1 = isset($argv[1]) ? $argv[1]:null;
// $argv_2 = isset($argv[2]) ? $argv[2]:null;


// $min =(int) substr('min=',4);
// $max =(int) substr('max=',4);


// $min = $min ?? 1;
// $max = $max ?? 100;

// $rand_number = rand($min,$max);

// var_dump($rand_number);
// // exit(1);


// while(true){
//     $user_input = (int) readline('Enter a number:');
//     //var_dump($user_input);

//     if($user_input > $rand_number){
//         printf("Try a lower number.\n");
//     }
//     else if($user_input < $rand_number){
//         printf("Try a bigger number.\n");
//     }else{
//         printf("Congrats! You guessed it right!");
//         break;
//     }
    
// }







// $argv_1 = isset($argv[1]) ? $argv[1] : null;
// $argv_2 = isset($argv[2]) ? $argv[2] : null;

// $min = $max = null;

// if ($argv_1 !== null) {
//     if (preg_match('/min=(\d+)/', $argv_1, $matches)) {
//         $min = (int)$matches[1];
//     }
// }

// if ($argv_2 !== null) {
//     if (preg_match('/max=(\d+)/', $argv_2, $matches)) {
//         $max = (int)$matches[1];
//     }
// }

// $min = $min ?? 1;
// $max = $max ?? 100;

// $rand_number = rand($min, $max);

// var_dump($rand_number);

// while (true) {
//     $user_input = readline('Enter a number: ');

//     if (!is_numeric($user_input)) {
//         printf("Invalid input. Please enter a valid number.\n");
//         continue;
//     }

//     $user_input = (int)$user_input;

//     if ($user_input > $rand_number) {
//         printf("Try a lower number.\n");
//     } elseif ($user_input < $rand_number) {
//         printf("Try a bigger number.\n");
//     } else {
//         printf("Congrats! You guessed it right!");
//         break;
//     }
// }



// $options = getopt('h::', ["min::", "max::"]);


//     $min = (int) ($options['min'] ?? 1);
//     $max = (int) ($options['max'] ?? 100);

//    $number = rand($min, $max);

// // var_dump($options['h']);

// if(isset($options['h'])){
//     printf("This is a guessing game application");
// }else{
//     while (true) {
//             $user_input = readline('Enter a number: ');
        
//             if (!is_numeric($user_input)) {
//                 printf("Invalid input. Please enter a valid number.\n");
//                 continue;
//             }
        
//             $user_input = (int)$user_input;
        
//             if ($user_input > $number) {
//                 printf("Try a lower number.\n");
//             } elseif ($user_input < $number) {
//                 printf("Try a bigger number.\n");
//             } else {
//                 printf("Congrats! You guessed it right!");
//                 break;
//             }
//         }
// }







