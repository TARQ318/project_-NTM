<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  // تشفير كلمة المرور

    // التحقق من وجود البريد الإلكتروني بالفعل في قاعدة البيانات
    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $existingStudent = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingStudent) {
        // إذا كان البريد الإلكتروني موجودًا بالفعل
        $message = "This email is already registered. Please use a different one.";
    } else {
        // إدخال الطالب في قاعدة البيانات
        $stmt = $pdo->prepare("INSERT INTO students (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
        $message = "Student registered successfully!";

        // إعادة التوجيه إلى صفحة الترحيب (index.php)
        session_start();
        $_SESSION['user_id'] = $pdo->lastInsertId(); // تخزين معرّف المستخدم الجديد
        $_SESSION['user_name'] = $name; // تخزين اسم المستخدم في الجلسة

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="DLMS.css">
</head>
<body>

    <!-- شريط التنقل -->
    <nav>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="login-librarian.php">Librarian Login</a>
    </nav>

    <div class="container">
        <h1>Register</h1>

        <?php if (!empty($message)) { echo "<div class='message'>$message</div>"; } ?>

        <div class="form-container">
            <h2>Create an Account</h2>
            <form method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="register">Register</button>
            </form>
        </div>
    </div>

</body>
</html>
