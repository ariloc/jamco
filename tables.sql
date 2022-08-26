CREATE DATABASE jamco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE jamco;

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

CREATE TABLE artists(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    description VARCHAR(8192) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    PRIMARY KEY (id)
);

CREATE TABLE albums(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    artist INT NOT NULL,
    release_date DATETIME,
    description VARCHAR(8192) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    PRIMARY KEY (id),
    FOREIGN KEY (artist) REFERENCES artists(id)
);

CREATE TABLE songs(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    release_date DATETIME,
    album INT,
    artist INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (artist) REFERENCES artists(id),
    FOREIGN KEY (album) REFERENCES albums(id)
);

CREATE TABLE reviews(
    id INT NOT NULL AUTO_INCREMENT,
    published_at TIMESTAMP DEFAULT current_timestamp(),
    usr INT NOT NULL,
    song INT NOT NULL,
    stars DECIMAL(2,1) NOT NULL,
    title VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    body VARCHAR(8192) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    PRIMARY KEY (id),
    FOREIGN KEY (usr) REFERENCES users(id),
    FOREIGN KEY (song) REFERENCES songs(id)
);

CREATE TABLE song_exhibitor(
    usr INT NOT NULL,
    song INT NOT NULL,
    FOREIGN KEY (usr) REFERENCES users(id),
    FOREIGN KEY (song) REFERENCES songs(id)
);
