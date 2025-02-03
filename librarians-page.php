<?php 
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

// إضافة كتاب جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_year = $_POST['published_year'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];

    // إدخال الكتاب الجديد في قاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO books (title, author, published_year, available_copies, total_copies) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $author, $published_year, $available_copies, $total_copies]);

    $message = "Book added successfully!";
}

// تحديث بيانات الكتاب
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_book'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_year = $_POST['published_year'];
    $available_copies = $_POST['available_copies'];
    $total_copies = $_POST['total_copies'];

    // تحديث بيانات الكتاب في قاعدة البيانات
    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, published_year = ?, available_copies = ?, total_copies = ? WHERE id = ?");
    $stmt->execute([$title, $author, $published_year, $available_copies, $total_copies, $book_id]);

    $message = "Book updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="DLMS.css">
</head>
<body>

    <!-- شريط التنقل -->
    <nav>
        
        <a href="logout.php">Logout</a> <!-- رابط لتسجيل الخروج -->
    </nav>

    <div class="container">
        <h1>Librarian Dashboard</h1>

        <?php if (!empty($message)) { echo "<div class='message'>$message</div>"; } ?>

        <!-- إضافة كتاب جديد -->
        <div class="form-container">
            <h2>Add New Book</h2>
            <form method="POST">
                <label for="title">Book Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author">

                <label for="published_year">Published Year:</label>
                <input type="number" id="published_year" name="published_year" required>

                <label for="total_copies">Total Copies:</label>
                <input type="number" id="total_copies" name="total_copies" required>

                <label for="available_copies">Available Copies:</label>
                <input type="number" id="available_copies" name="available_copies" required>

                <button type="submit" name="add_book">Add Book</button>
            </form>
        </div>

        <!-- تحديث كتاب موجود -->
        <div class="form-container">
            <h2>Update Book Information</h2>
            <form method="POST">
                <label for="book_id">Select Book to Update:</label>
                <select id="book_id" name="book_id" required>
                    <?php
                    $stmt = $pdo->query("SELECT id, title FROM books");
                    while ($book = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=\"" . htmlspecialchars($book['id']) . "\">" . htmlspecialchars($book['title']) . "</option>";
                    }
                    ?>
                </select>

                <label for="title">Book Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author">

                <label for="published_year">Published Year:</label>
                <input type="number" id="published_year" name="published_year" required>

                <label for="total_copies">Total Copies:</label>
                <input type="number" id="total_copies" name="total_copies" required>

                <label for="available_copies">Available Copies:</label>
                <input type="number" id="available_copies" name="available_copies" required>

                <button type="submit" name="update_book">Update Book</button>
            </form>
        </div>

        <!-- عرض جميع الكتب -->
        <div class="form-container">
            <h2>All Books</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Published Year</th>
                        <th>Available Copies</th>
                        <th>Total Copies</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM books");
                    while ($book = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($book['title']) . "</td>
                                <td>" . htmlspecialchars($book['author']) . "</td>
                                <td>" . htmlspecialchars($book['published_year']) . "</td>
                                <td>" . htmlspecialchars($book['available_copies']) . "</td>
                                <td>" . htmlspecialchars($book['total_copies']) . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
