-- SQL Schema for AI Prize Draw Web App
-- Compatible with Hostinger (MySQL 5.7+)

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    position VARCHAR(100),
    rank VARCHAR(50),
    hire_date DATE,
    weight FLOAT DEFAULT 1.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE prizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prize_name VARCHAR(150) NOT NULL,
    category ENUM('Expensive', 'Medium', 'Modest') NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE draw_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    draw_name VARCHAR(100) NOT NULL,
    num_expensive INT DEFAULT 0,
    num_medium INT DEFAULT 0,
    num_modest INT DEFAULT 0,
    eligibility_min_years INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE draws (
    id INT AUTO_INCREMENT PRIMARY KEY,
    draw_setting_id INT,
    prize_id INT,
    employee_id INT,
    category ENUM('Expensive', 'Medium', 'Modest'),
    drawn_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (draw_setting_id) REFERENCES draw_settings(id) ON DELETE CASCADE,
    FOREIGN KEY (prize_id) REFERENCES prizes(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- Optional: Log of uploads for auditing
CREATE TABLE uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uploaded_by INT,
    file_name VARCHAR(255),
    file_type ENUM('employees', 'prizes'),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
);
