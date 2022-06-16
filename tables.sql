CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT, 
    username VARCHAR(32) NOT NULL UNIQUE, 
    email VARCHAR(64) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL, 
    valid_state TINYINT NOT NULL DEFAULT 0,
    activation_token VARCHAR(255),
    country_code CHAR(2), 
    created_at TIMESTAMP DEFAULT current_timestamp(), 
    login_times INT NOT NULL DEFAULT 0, 
    last_login TIMESTAMP NULL, 
    nickname VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, 
    birth DATETIME, 
    activation_expiry TIMESTAMP NULL,
    PRIMARY KEY (id)
);

