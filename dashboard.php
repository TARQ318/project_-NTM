<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

session_start(); // بدء الجلسة

// التحقق من أن المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // معرف المستخدم من الجلسة

// جلب البيانات المتعلقة بالاستعارات التي لم يتم إرجاعها لهذا المستخدم فقط
$stmt = $pdo->prepare("
    SELECT students.name, students.email, books.title, borrows.borrowed_at, borrows.due_date
    FROM borrows
    JOIN students ON borrows.student_id = students.id
    JOIN books ON borrows.book_id = books.id
    WHERE borrows.returned_at IS NULL AND borrows.student_id = ?
");
$stmt->execute([$user_id]); // تنفيذ الاستعلام مع التصفية بواسطة معرف الطالب
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Items Dashboard</title>
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

    <h1>Borrowed Items Dashboard</h1>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Book Title</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // عرض الاستعارات للمستخدم
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // التحقق مما إذا كان الكتاب متأخرًا
                $isOverdue = (strtotime($row['due_date']) < time()) ? 'style="color: red;"' : '';
                echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['borrowed_at']) . "</td>
                        <td $isOverdue>" . htmlspecialchars($row['due_date']) . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
