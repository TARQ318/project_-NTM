
# Digital Library Management System

This project is a simple **Digital Library Management System** implemented in PHP with a MySQL database. The system includes the following functionalities:

1. **Register a student**
2. **Search for books**
3. **Borrow books**
4. **Return borrowed books**
5. **Dashboard for borrowed books**

---

## Project Files and Functionalities

### 1. **`register_student.php`**
Allows users to register new students into the system.

#### Features:
- Input fields for student name and email.
- Validates the email format and ensures the name is not empty.
- Inserts student data into the `students` table in the database.

#### Code Highlights:
- Data validation using `filter_var()` for email.
- Prepared statements (`$pdo->prepare`) to prevent SQL injection.

#### Navigation Links:
- **Register Student**
- **Search Books**
- **Borrow Books**
- **Dashboard**

---

### 2. **`search_books.php`**
Allows users to search for books available in the library.

#### Features:
- Search bar to input the book title.
- Displays books that match the search query and are marked as available in the database.
- Utilizes SQL `LIKE` and filters only `available` books.

#### Code Highlights:
- Uses `$_GET` to retrieve search queries.
- Escapes HTML content with `htmlspecialchars()` to avoid XSS.

---

### 3. **`borrow_books.php`**
Handles the borrowing of books by students.

#### Features:
- Input fields for student email and book selection.
- Validates the existence of the student and the availability of the book.
- Inserts a record into the `borrows` table and marks the book as unavailable.
- Displays a success or failure message.

#### Code Highlights:
- Dropdown menu dynamically populated with available books.
- Updates the `books` table to set the `available` column to `0` when a book is borrowed.
- Uses multiple prepared statements to ensure safe database operations.

---

### 4. **`return_book.php`**
Enables users to return borrowed books.

#### Features:
- Dropdown menu populated with currently borrowed books that have not been returned.
- Updates the `borrows` table to set the `returned_at` column with the current timestamp.
- Increments the `available_copies` count in the `books` table.
- Displays a success message after the return is processed.

#### Code Highlights:
- Joins `borrows` and `books` tables to fetch currently borrowed books.
- Updates multiple tables using prepared statements to maintain data consistency.
- Uses `htmlspecialchars()` to escape content and prevent XSS.

#### Navigation Links:
- **Register Student**
- **Search Books**
- **Borrow Books**
- **Return Book**
- **Dashboard**

---

### 5. **`dashboard.php`**
Displays a dashboard with all borrowed books.

#### Features:
- Displays the student's name, email, borrowed book title, and borrow date.
- Joins data from the `students`, `books`, and `borrows` tables.

#### Code Highlights:
- SQL `JOIN` queries to combine related data across multiple tables.
- Dynamically renders data in an HTML table.

---

## Database Structure

### Tables:

1. **`students`**
   - `id` (Primary Key, Auto Increment)
   - `name` (VARCHAR)
   - `email` (VARCHAR)

2. **`books`**
   - `id` (Primary Key, Auto Increment)
   - `title` (VARCHAR)
   - `available_copies` (INT)

3. **`borrows`**
   - `id` (Primary Key, Auto Increment)
   - `student_id` (Foreign Key, References `students.id`)
   - `book_id` (Foreign Key, References `books.id`)
   - `borrowed_at` (TIMESTAMP)
   - `returned_at` (TIMESTAMP, NULLABLE)

---

## How to Run the Project

1. **Set Up the Database:**
   - Create a MySQL database.
   - Import the provided SQL file (`DLMS.sql`) included in the project directory to set up the database structure and initial data.

     ```bash
     mysql -u your_username -p your_database_name < DLMS.sql
     ```

2. **Configure Database Connection:**
   - Update the `database.php` file with your database credentials:
     ```php
     $pdo = new PDO('mysql:host=localhost;dbname=your_database_name', 'username', 'password');
     ```

3. **Run on Localhost:**
   - Place all project files in your server's root directory (e.g., `htdocs` for XAMPP).
   - Access the files via your browser (e.g., `http://localhost/register_student.php`).

---

## File Structure
```
project-folder/
|-- register_student.php
|-- search_books.php
|-- borrow_books.php
|-- return_book.php
|-- dashboard.php
|-- database.php
|-- DLMS.sql
|-- DLMS.css
```

---

## Future Enhancements
- Add user authentication for admins.
- Display overdue books and implement penalty calculation.
- Enhance the UI with additional styling and JavaScript interactivity.

---

## License
This project is open-source and free to use for educational purposes.
