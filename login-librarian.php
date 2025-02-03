<?php
// بدء الجلسة
session_start();

// التحقق مما إذا كان المستخدم قد قام بإرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // التحقق من أن اسم المستخدم هو "admin" وكلمة المرور هي "123"
    if ($email == 'admin@gmail.com' && $password == '123') {
        // إذا كانت البيانات صحيحة، تخزين معلومات الجلسة
        $_SESSION['user_id'] = 1; // يمكن تخصيص أي معرف
        $_SESSION['user_name'] = 'admin';
        $_SESSION['role'] = 'librarian'; // تحديد الدور على أنه أمين مكتبة

        // إعادة التوجيه إلى صفحة أمين المكتبة
        header("Location: librarians-page.php");
        exit;
    } else {
        // إذا كانت بيانات الدخول خاطئة
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Login</title>
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
        <h1>Librarian Login</h1>

        <!-- عرض الرسالة إذا كانت موجودة -->
        <?php if (!empty($message)) { echo "<p><strong>$message</strong></p>"; } ?>

        <div class="form-container">
            <h2>Login as a Librarian </h2>
        <!-- نموذج تسجيل الدخول -->
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
            </form>
            </div>
            </div>
            </body>
            </html>
