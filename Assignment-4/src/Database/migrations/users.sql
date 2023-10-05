CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (role, name, email, password) VALUES ('admin', 'admin', 'admin@gmail.com', '$2y$10$YRHsyLuCl0p19KFdu.rUA.zuIB.X1hNkzLJ5EsU9mo0pg4ei.HqIO');