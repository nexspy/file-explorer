#!/usr/bin/php -q
<?php


// $argv = arguments
// including filename

// $argc = arguments count


// shifting args will remove filename
array_shift($argv);

if (isset($argv[0])) {
  printf("Hello, %s!", $argv[0]);
} else {
  print('Noone to greet');
}

/**
 * Taking user input
 */
$line = trim(fgets(STDIN)); // reads one line from STDIN
fscanf(STDIN, "%d\n", $input); // reads number from STDIN
printf("You entered %d", $input);




// you can input <Enter> or 1, 2, 3 
$choice = ReadStdin('Please choose your answer or press Enter to continue: ', array('', '1', '2', '3')); 


// check input is valid file name, use /var/path for input nothing 
$file = ReadStdin('Please input the file name(/var/path):', 'is_file', '/var/path'); 

function ReadStdin($prompt, $valid_inputs, $default = '') { 
    while(!isset($input) || (is_array($valid_inputs) && !in_array($input, $valid_inputs)) || ($valid_inputs == 'is_file' && !is_file($input))) { 
        echo $prompt; 
        $input = strtolower(trim(fgets(STDIN))); 
        if(empty($input) && !empty($default)) { 
            $input = $default; 
        } 
    } 
    return $input; 
} 
?>