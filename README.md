# Digital Library Management System (DLMS)

Welcome to the Digital Library Management System (DLMS)! This project provides a simple and effective web interface for managing e-books, student registration, and borrowing activities. Below is a detailed overview of the features, structure, and usage instructions for this project.

---

## Features

### 1. Home Page
- Central hub to navigate DLMS features.
- File: index.html
- Links:
  - Student Registration
  - Search E-books
  - Borrow E-books
  - Borrowed Items Dashboard

---

### 2. Student Registration
- Allows students to register by entering their name and email.
- Displays a list of registered students.
- Prevents duplicate email registrations.
- File: register.html

#### Key Functionality
- Inputs:
  - Name
  - Email
- Outputs:
  - List of registered students.
- JavaScript Function:
  - registerStudent(): Validates inputs and adds the student to the list.

---

### 3. Search E-books
- Provides an interface to search for available e-books.
- Displays a default list of books and filters them based on user input.
- File: search.html

#### Key Functionality
- Input:
  - Search Query
- Outputs:
  - List of books matching the search query.
- JavaScript Functions:
  - displayBooks(): Dynamically displays books.
  - searchBooks(): Filters the list based on the user query.

#### Default Book List
- Includes a variety of topics like Python, JavaScript, Machine Learning, and more.

---

### 4. Borrow E-books
- Allows users to borrow e-books.
- Prevents duplicate borrowing of the same book by the same person.
- File: borrow-faculty.html

#### Key Functionality
- Inputs:
  - Name
  - Selected Book
- Outputs:
  - List of borrowed books with borrower details.
- JavaScript Function:
  - borrowBook(): Validates inputs and adds borrowing details to the list.

---

### 5. Borrowed Items Dashboard
- Displays a list of all borrowed books with borrower details.
- File: dashboard.html

#### Key Functionality
- Static display of borrowed books for review.

---

## File Structure

```plaintext
DLMS/
│
├── index.html               # Home Page
├── register.html            # Student Registration
├── search.html              # Search E-books
├── borrow-faculty.html      # Borrow E-books
├── dashboard.html           # Borrowed Items Dashboard
└── README.md                # Project Documentation (this file)
