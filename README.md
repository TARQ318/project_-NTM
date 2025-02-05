# Digital Library Management System (DLMS)

## Overview
The Digital Library Management System (DLMS) is a web-based application that allows users to search, borrow, and return books. It provides an efficient way for students and librarians to manage library resources.

## Features
- User authentication (login/logout system)
- Search for available books
- Borrow and return books
- Librarian dashboard for managing books
- Track borrowed books with due dates

## Technologies Used
- PHP (Backend)
- MySQL (Database)
- HTML, CSS (Frontend)

## Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/DLMS.git
   ```
2. Import the database:
   - Navigate to your MySQL interface (e.g., phpMyAdmin)
   - Create a new database named `DLMS`
   - Run the SQL script provided in `DLMS.sql`
3. Configure database connection:
   - Update `database.php` with your MySQL credentials
4. Start the project:
   - Run a local server (e.g., XAMPP, MAMP)
   - Open `http://localhost/DLMS/` in your browser

## File Structure
```
DLMS/
│-- index.php          # Home page
│-- login.php          # User authentication
│-- logout.php         # Logout functionality
│-- register.php       # User registration
│-- search.php         # Search for books
│-- borrow.php         # Borrow books
│-- return.php         # Return borrowed books
│-- dashboard.php      # User dashboard
│-- librarian-page.php      # Librarian dashboard
│-- database.php       # Database connection
│-- DLMS.css           # Stylesheet
│-- DLMS.sql       # SQL script for database setup
└── README.md          # Project documentation
```

## Database Schema
The system consists of the following tables:

### `students`
Stores student information.
```
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### `books`
Stores book details.
```
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    published_year INT,
    available_copies INT DEFAULT 1,
    total_copies INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### `borrows`
Tracks borrowed books.
```
CREATE TABLE borrows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    book_id INT NOT NULL,
    borrowed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    due_date DATE NOT NULL,
    returned_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);
```

### `librarians`
Stores librarian credentials.
```
CREATE TABLE librarians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'librarian',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## License
This project is open-source and available under the MIT License.

