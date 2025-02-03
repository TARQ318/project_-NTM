<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

session_start(); // بدء الجلسة

$message = "";

// التحقق من أن المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // معرف المستخدم من الجلسة

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $book_title = $_POST['book_title'];

    // تحقق من وجود الطالب بناءً على معرف المستخدم في الجلسة
    $stmtStudent = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmtStudent->execute([$user_id]);
    $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

    // تحقق من وجود الكتاب
    $stmtBook = $pdo->prepare("SELECT * FROM books WHERE title = ?");
    $stmtBook->execute([$book_title]);
    $book = $stmtBook->fetch(PDO::FETCH_ASSOC);

    if ($student && $book && $book['available_copies'] > 0) {
        // سجل الاستعارة في قاعدة البيانات
        $stmtBorrow = $pdo->prepare("INSERT INTO borrows (student_id, book_id, borrowed_at, due_date) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY))");
        $stmtBorrow->execute([$student['id'], $book['id']]);

        // تحديث حالة الكتاب بتقليل النسخ المتاحة
        $stmtUpdateBook = $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
        $stmtUpdateBook->execute([$book['id']]);

        $message = "Book borrowed successfully!";
    } else {
        $message = "Student or book not found, or no available copies.";
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
        <a href="index.php">Home</a>
        <a href="search.php">Search Books</a>
        <a href="borrow.php">Borrow Books</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="return.php">Return Book</a>
        <a href="logout.php">Logout</a> <!-- رابط لتسجيل الخروج -->
    </nav>

    <h1>Borrow Books</h1>

    <?php if (!empty($message)) { echo "<p><strong>$message</strong></p>"; } ?>

    <form method="POST">
        <label for="book_title">Book Title:</label>
        <select id="book_title" name="book_title" required>
            <?php
            $stmt = $pdo->query("SELECT * FROM books WHERE available_copies > 0");
            while ($book = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option>" . htmlspecialchars($book['title']) . "</option>";
            }
            ?>
        </select>

        <button type="submit" name="borrow">Borrow</button>
    </form>
</body>
</html>
