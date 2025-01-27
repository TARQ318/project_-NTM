<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

// جلب البيانات المتعلقة بالاستعارات التي لم يتم إرجاعها
$stmt = $pdo->query("
    SELECT students.name, students.email, books.title, borrows.borrowed_at, borrows.due_date
    FROM borrows
    JOIN students ON borrows.student_id = students.id
    JOIN books ON borrows.book_id = books.id
    WHERE borrows.returned_at IS NULL
");
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
        <a href="register_student.php">Register Student</a>
        <a href="search_books.php">Search Books</a>
        <a href="borrow_books.php">Borrow Books</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="return_book.php">Return Book</a>
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
