<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $student_email = $_POST['student_email'];
    $book_title = $_POST['book_title'];

    // تحقق من وجود الطالب
    $stmtStudent = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmtStudent->execute([$student_email]);
    $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

    // تحقق من وجود الكتاب
    $stmtBook = $pdo->prepare("SELECT * FROM books WHERE title = ?");
    $stmtBook->execute([$book_title]);
    $book = $stmtBook->fetch(PDO::FETCH_ASSOC);

    if ($student && $book) {
        // سجل الاستعارة في قاعدة البيانات
        $stmtBorrow = $pdo->prepare("INSERT INTO borrows (student_id, book_id) VALUES (?, ?)");
        $stmtBorrow->execute([$student['id'], $book['id']]);

        // تحديث حالة الكتاب إلى غير متاح
        $stmtUpdateBook = $pdo->prepare("UPDATE books SET available = 0 WHERE id = ?");
        $stmtUpdateBook->execute([$book['id']]);

        $message = "Book borrowed successfully!";
    } else {
        $message = "Student or book not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Books</title>
    <link rel="stylesheet" href="DLMS.css">
</head>
<body>
    <!-- شريط التنقل -->
    <nav>
        <a href="register_student.php">Register Student</a>
        <a href="search_books.php">Search Books</a>
        <a href="borrow_books.php">Borrow Books</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>

    <h1>Borrow Books</h1>

    <?php if (!empty($message)) { echo "<p><strong>$message</strong></p>"; } ?>

    <form method="POST">
        <label for="student_email">Student Email:</label>
        <input type="email" id="student_email" name="student_email" required>

        <label for="book_title">Book Title:</label>
        <select id="book_title" name="book_title" required>
            <?php
            $stmt = $pdo->query("SELECT * FROM books WHERE available = 1");
            while ($book = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option>" . htmlspecialchars($book['title']) . "</option>";
            }
            ?>
        </select>

        <button type="submit" name="borrow">Borrow</button>
    </form>
</body>
</html>
