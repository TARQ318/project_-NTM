<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

// جلب البيانات المتعلقة بالاستعارات
$stmt = $pdo->query("SELECT students.name, students.email, books.title, borrows.borrowed_at
                     FROM borrows
                     JOIN students ON borrows.student_id = students.id
                     JOIN books ON borrows.book_id = books.id");
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
    </nav>

    <h1>Borrowed Items Dashboard</h1>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Book Title</th>
                <th>Borrow Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['borrowed_at']) . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
