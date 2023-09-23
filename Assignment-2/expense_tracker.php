<?php

class Transaction {
    public $name;
    public $amount;
    public $category;

    public function __construct($name, $amount, $category) {
        $this->name = $name;
        $this->amount = $amount;
        $this->category = $category;
    }

    public function toArray() {
        return [
            'name' => $this->name,
            'amount' => $this->amount,
            'category' => $this->category,
        ];
    }
}

class Category {
    public $name;
    public $transactions = [];

    public function __construct($name) {
        $this->name = $name;
    }

    public function addTransaction($transaction) {
        $this->transactions[] = $transaction;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->transactions as $transaction) {
            $total += $transaction->amount;
        }
        return $total;
    }

    public function toArray() {
        $transactionArray = [];
        foreach ($this->transactions as $transaction) {
            $transactionArray[] = $transaction->toArray();
        }
        return [
            'name' => $this->name,
            'transactions' => $transactionArray,
        ];
    }
}

class App {
    public $categories = [];

    public function addCategory($name) {
        $category = new Category($name);
        $this->categories[] = $category;
    }

    public function findCategoryByName($categoryName) {
        foreach ($this->categories as $category) {
            if ($category->name === $categoryName) {
                return $category;
            }
        }
        return null; // Return null if the category is not found
    }

    public function addTransaction($name, $amount, $categoryName) {

        $category = $this->findCategoryByName($categoryName);

        if ($category) {
            $transaction = new Transaction($name, $amount, $categoryName);
            $category->addTransaction($transaction);
        } else {
            echo "Category '$categoryName' does not exist." . PHP_EOL;
        }
    }

    public function viewCategories() {
        foreach ($this->categories as $category) {
            echo "Category: {$category->name}" . PHP_EOL;
            $total = $category->getTotal();
            echo "Total: $total" . PHP_EOL;
            echo "Transactions:" . PHP_EOL;
            foreach ($category->transactions as $transaction) {
                echo "{$transaction->name}: {$transaction->amount}" . PHP_EOL;
            }
            echo PHP_EOL;
        }
    }

    public function saveData() {
        $data = ['categories' => []];
        foreach ($this->categories as $category) {
            $data['categories'][] = $category->toArray();
        }
        file_put_contents('data.json', json_encode($data));
    }

    public function loadData() {
        if (file_exists('data.json')) {
            $data = json_decode(file_get_contents('data.json'), true);
            foreach ($data['categories'] as $categoryData) {
                $category = new Category($categoryData['name']);
                foreach ($categoryData['transactions'] as $transactionData) {
                    $transaction = new Transaction($transactionData['name'], $transactionData['amount'], $categoryData['name']);
                    $category->addTransaction($transaction);
                }
                $this->categories[] = $category;
            }
        }
    }
}



$app = new App();


while (true) {
    echo "Income and Expense Tracker" . PHP_EOL;
    echo "1. Add Category" . PHP_EOL;
    echo "2. Add Transaction" . PHP_EOL;
    echo "3. View Categories" . PHP_EOL;
    echo "4. Quit" . PHP_EOL;

    $choice = readline("Enter your choice: ");

    if ($choice === "1") {
        $name = readline("Enter category name: ");
        $app->addCategory($name);
        
    } elseif ($choice === "2") {
        $name = readline("Enter transaction name: ");
        $amount = readline("Enter transaction amount: ");
        
        // Validate the amount as a numeric value
        if (!is_numeric($amount)) {
            echo "Invalid amount. Please enter a numeric value." . PHP_EOL;
            continue;
        }

        $category = readline("Enter category name: ");
        $app->addTransaction($name, $amount, $category);
    } elseif ($choice === "3") {
        $app->viewCategories();
    } elseif ($choice === "4") {
        $app->saveData(); // Save data before quitting
        break;
    }
}



