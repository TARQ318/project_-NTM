<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // التحقق من وجود البريد الإلكتروني بالفعل في قاعدة البيانات
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $existingStudent = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingStudent) {
            // إذا كان البريد الإلكتروني موجودًا بالفعل
            $message = "This email is already registered. Please use a different one.";
        } else {
            // إدخال الطالب في قاعدة البيانات
            $stmt = $pdo->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
            $stmt->execute([$name, $email]);
            $message = "Student registered successfully!";
            
            // إعادة التوجيه إلى صفحة البحث عن الكتب
            header("Location: search_books.php");
            exit; // تأكد من إنهاء التنفيذ بعد التوجيه
        }
    } else {
        $message = "Invalid input. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student</title>
    <link rel="stylesheet" href="DLMS.css">
</head>
<body>
    <!-- شريط التنقل -->
    <nav>
        <a href="register_student.php">Register Student</a>
        <a href="search_books.php">Search Books</a>
        <a href="borrow_books.php">Borrow Books</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="return_book.php">Return book</a>
    </nav>

    <h1>Register Student</h1>

    <?php if (!empty($message)) { echo "<p><strong>$message</strong></p>"; } ?>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>
