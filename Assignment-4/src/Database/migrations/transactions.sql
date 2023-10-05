CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    receiver_id INT NULL,
    transaction_type ENUM('deposit', 'withdraw', 'transfer') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_date DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
