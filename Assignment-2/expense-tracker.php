#! /usr/bin/env php
<?php 

//serial number enum
enum SerialNumber:int{
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
}


//Expense tracker class
class ExpenseTracker{


    //constructor function 
    public function __construct(){

        $this->incomeExpense();
    }


    //add income function
    public function add_income(){

        $amount = readline('Write a number of amount: ');
        
        if(!is_numeric($amount)){
            printf('Write a valid number!'.PHP_EOL);
            return;

        }else{

            $amount = (int) $amount;

            $category = readline('Enter an income category: ');
    
            $income_sources = ['Salary','Business','Rent'];
    
            if(!in_array($category,$income_sources)){
    
                printf('Invalid category! Please see the list of valid income categories in View Categories'.PHP_EOL);
                return;
            }

        $filename = 'income.txt';

        // Read the existing data into an array
        $file = fopen($filename, 'r');

        //var_dump(fgets($file));

        $lines = [];
        
        if ($file) {
            
            while (($line = fgets($file)) !== false) {
                $lines[] = trim($line);
            }

            fclose($file);

        } 
        else {
            printf("Unable to open the file.");
            return;
        }

        //var_dump($lines);

    
        // Find and update the line for the specified category
        $found = false;

        foreach ($lines as &$line) {

            $parts = explode(':', $line);

        //    var_dump(count($parts));
        //    return;

            if (count($parts) === 2 && trim($parts[0]) === $category) {

                $existingAmount = (int) trim($parts[1]);

                $newAmount = $existingAmount + $amount;

                $line = "$category: $newAmount";

                $found = true;

                break; // No need to continue searching
            }
        }
    
        // If the category wasn't found, add it as a new entry

        if (!$found) {
            $lines[] = "$category:$amount";
        }
    
        // Write the updated data back to the file
        $file = fopen($filename, 'w');

        if ($file) {

            foreach ($lines as $line) {
                fwrite($file, $line . PHP_EOL);
            }

            fclose($file);

            printf("Income added successfully!");

        } else {
            echo "Error: Unable to open the file for writing.";
        }
    
        printf(PHP_EOL);
        $this->incomeExpense();

        }
    }

    //add expense function
    public function add_expense(){

        $amount = readline('Write a number of amount: ');
        
        if(!is_numeric($amount)){
            printf('Write a valid number!'.PHP_EOL);
            return;

        }else{

            $amount = (int) $amount;

            $category = readline('Enter an expense category: ');

            $expense_sources = ['Family','Personal','Recreation','Sadakah','Gift'];

            if(!in_array($category,$expense_sources)){

                printf('Invalid category! Please see the list of valid expense categories in View Categories'.PHP_EOL);
                return;
            }

            $filename = 'expense.txt';
    
            // Read the existing data into an array
            $file = fopen($filename, 'r');

            // var_dump($file);
            // return;

            $lines = [];
            
            if ($file) {
                
                while (($line = fgets($file)) !== false) {
                    $lines[] = trim($line);
                }

                fclose($file);

            } else {
                printf("Unable to open the file.");
                return;
            }

            //var_dump($lines);

        
            // Find and update the line for the specified category
            $found = false;

            foreach ($lines as &$line) {

                $parts = explode(':', $line);

                if (count($parts) === 2 && trim($parts[0]) === $category) {

                    $existingAmount = (int) trim($parts[1]);
                    $newAmount = $existingAmount + $amount;
                    $line = "$category: $newAmount";
                    $found = true;
                    break; // No need to continue searching
                }
            }
        
            // If the category wasn't found, add it as a new entry

            if (!$found) {
                $lines[] = "$category:$amount";
            }
        
            // Write the updated data back to the file
            $file = fopen($filename, 'w');

            if ($file) {

                foreach ($lines as $line) {
                    fwrite($file, $line . PHP_EOL);
                }

                fclose($file);

                printf("Expense added successfully!");

            } else{
               printf("Unable to open the file for writing.");
            }
        
            printf(PHP_EOL);

            $this->incomeExpense();

            }
    }

    public function view_income() {
        $filename = 'income.txt';
        
        if (file_exists($filename)) {
            $lines = file($filename, FILE_IGNORE_NEW_LINES);

            printf(PHP_EOL);
            
            foreach ($lines as $line) {
               printf($line . PHP_EOL);
            }

        } else {
            printf("Income data not available." . PHP_EOL);
        }
        $this->incomeExpense();
    }

    public function view_expense() {
        $filename = 'expense.txt';
        if (file_exists($filename)) {

            $lines = file($filename, FILE_IGNORE_NEW_LINES);

            printf(PHP_EOL);

            foreach ($lines as $line) {
                printf($line . PHP_EOL);
            }
        } else {
            printf("Expense data not available." . PHP_EOL);
        }

        $this->incomeExpense();
    }

    //view savings method
    public function view_savings() {

        $incomeFile = 'income.txt';
        $expenseFile = 'expense.txt';

        $totalIncome = 0;

        if (file_exists($incomeFile)) {

            $lines = file($incomeFile, FILE_IGNORE_NEW_LINES);

            foreach ($lines as $line) {

                $parts = explode(':', $line);

                if (count($parts) === 2) {
                    $totalIncome += (int)trim($parts[1]);
                }
            }
        }

        $totalExpense = 0;

        if (file_exists($expenseFile)) {

            $lines = file($expenseFile, FILE_IGNORE_NEW_LINES);

            foreach ($lines as $line) {

                $parts = explode(':', $line);

                if (count($parts) === 2) {
                    $totalExpense += (int)trim($parts[1]);
                }
            }
        }

        printf(PHP_EOL);

        $total = $totalIncome - $totalExpense;
        echo "Total Income: $totalIncome" . PHP_EOL;
        echo "Total Expense: $totalExpense" . PHP_EOL;
        echo "Total Savings: $total" . PHP_EOL;

        $this->incomeExpense();
    }


    //view category function
    public function view_categories() {

            printf(PHP_EOL);

            $categories_source = [
                'Income'=>['Salary','Business','Rent'],
                'Expense'=>['Family','Personal','Recreation','Sadakah','Gift'],
            ];
          
            foreach($categories_source as $category_key=>$category_value){

                printf($category_key.' categories '.PHP_EOL);
                
                printf(PHP_EOL);

                foreach($category_value as $key=>$category){

                    printf(($key + 1).'. '.$category.PHP_EOL);
                } 

                printf(PHP_EOL);
            }

            $this->incomeExpense();

        
    
    }


    public function incomeExpense(){

            printf(PHP_EOL);
            printf("---------------------------");
            printf(PHP_EOL);

            printf('What do you want to do ?'.PHP_EOL);
            printf('1. Add income'.PHP_EOL);
            printf('2. Add expense'.PHP_EOL);
            printf('3. View income'.PHP_EOL);
            printf('4. View expense'.PHP_EOL);
            printf('5. View savings'.PHP_EOL);
            printf('6. View categories'.PHP_EOL);
        
            $user_input = readline('Enter your option: ');
            if(!is_numeric($user_input)){
                printf('Enter a valid number!'.PHP_EOL);
            }
 
            $user_input = (int) $user_input;


            if($user_input == SerialNumber::One->value){
    
                $this->add_income();
            }
            else if($user_input == SerialNumber::Two->value){
                $this->add_expense();
            }
            else if($user_input == SerialNumber::Three->value){
                $this->view_income();
            }
            else if($user_input == SerialNumber::Four->value){
                $this->view_expense();
            }
            else if($user_input == SerialNumber::Five->value){
                    $this->view_savings();
            }
            else if($user_input == SerialNumber::Six->value){
                $this->view_categories($user_input);
            }
    }

}

//Instantiate an ExpenseTracker object
$expense_tracker = new ExpenseTracker();




