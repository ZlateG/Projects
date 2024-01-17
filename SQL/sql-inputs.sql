-- create the database
CREATE DATABASE library;

-- create the users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    user_uid VARCHAR(50) NOT NULL,
    user_pwd VARCHAR(255) NOT NULL,
    user_email VARCHAR(50) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0
);

-- create authors table
CREATE TABLE authors (
    author_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    short_bio VARCHAR(255) NOT NULL,
    is_deleted TINYINT(1) DEFAULT 0
);

-- create category table
CREATE TABLE category (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(50) NOT NULL,
    is_deleted TINYINT(1) DEFAULT 0
);

-- create book table
CREATE TABLE books (
    book_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    author_id INT NOT NULL,
    published_at DATE NOT NULL,
    no_of_pages INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    category_id INT NOT NULL,
    is_deleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (author_id) REFERENCES authors(author_id),
    FOREIGN KEY (category_id) REFERENCES category(category_id)
);

-- create the comments table

CREATE TABLE comments (
    comments_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    comment VARCHAR (255) NOT NULL,
    is_approved TINYINT(1) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id)
);


CREATE TABLE notes (
    note_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    note TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id)
);

CREATE TABLE shopping_cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1, 
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id)
);


-- junkyard
