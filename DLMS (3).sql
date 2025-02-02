CREATE DATABASE DLMS;
USE DLMS;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    published_year INT,
    available_copies INT DEFAULT 1, -- عدد النسخ المتاحة
    total_copies INT DEFAULT 1,    -- إجمالي عدد النسخ
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO books (title, author, published_year, available_copies, total_copies) VALUES
('Introduction to Programming', 'John Doe', 2015, 5, 5),
('Advanced PHP Development', 'Jane Smith', 2020, 3, 3),
('Mastering MySQL', 'James Brown', 2018, 4, 4),
('Web Development Basics', 'Alice Johnson', 2019, 2, 2),
('JavaScript for Beginners', 'Robert White', 2021, 6, 6);


CREATE TABLE borrows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    book_id INT NOT NULL,
    borrowed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    due_date DATE NOT NULL, -- تاريخ الاستحقاق
    returned_at TIMESTAMP NULL, -- تاريخ الإرجاع (إذا تمت الإرجاع)
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);
