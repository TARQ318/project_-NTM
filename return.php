<?php
include 'database.php';

session_start(); // بدء الجلسة

$message = "";

// التحقق من أن المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // معرف المستخدم من الجلسة

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return'])) {
    $borrow_id = $_POST['borrow_id'];

    // تحقق من أن الاستعارة تخص المستخدم الحالي
    $stmtCheck = $pdo->prepare("SELECT * FROM borrows WHERE id = ? AND student_id = ?");
    $stmtCheck->execute([$borrow_id, $user_id]);
    $borrow = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($borrow) {
        // تحديث سجل الاستعارة بإضافة تاريخ الإرجاع
        $stmt = $pdo->prepare("UPDATE borrows SET returned_at = NOW() WHERE id = ?");
        $stmt->execute([$borrow_id]);

        // زيادة النسخ المتاحة للكتاب
        $stmtBook = $pdo->prepare("
            UPDATE books 
            SET available_copies = available_copies + 1
            WHERE id = (SELECT book_id FROM borrows WHERE id = ?)
        ");
        $stmtBook->execute([$borrow_id]);

        $message = "Book returned successfully!";
    } else {
        $message = "This borrow record does not belong to you or does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Borrowed Book</title>
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

    <h1>Return Borrowed Book</h1>

    <?php if (!empty($message)) { echo "<p><strong>$message</strong></p>"; } ?>

    <form method="POST">
        <label for="borrow_id">Select Borrowed Book:</label>
        <select id="borrow_id" name="borrow_id" required>
            <?php
            // جلب الكتب المستعارة التي تخص المستخدم الحالي فقط
            $stmt = $pdo->prepare("
                SELECT borrows.id, books.title 
                FROM borrows
                JOIN books ON borrows.book_id = books.id
                WHERE borrows.returned_at IS NULL AND borrows.student_id = ?
            ");
            $stmt->execute([$user_id]);

            while ($borrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"" . htmlspecialchars($borrow['id']) . "\">" . htmlspecialchars($borrow['title']) . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="return">Return Book</button>
    </form>
</body>
</html>
