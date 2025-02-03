<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

session_start(); // بدء الجلسة

// التحقق إذا كان المستخدم قد سجل الدخول بالفعل
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'librarian') {
        header("Location: librarians-page.php"); // إذا كان المستخدم أمين مكتبة، إعادة توجيه إلى صفحة أمين المكتبة
    } else {
        header("Location: dashboard.php"); // إذا كان المستخدم عادي، إعادة توجيه إلى لوحة تحكم الطالب
    }
    exit;
}

$message = "";

// التحقق من البيانات المدخلة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // التحقق من بيانات الدخول في جدول librarians
    $stmt = $pdo->prepare("SELECT * FROM librarians WHERE email = ?");
    $stmt->execute([$email]);
    $librarian = $stmt->fetch(PDO::FETCH_ASSOC);

    // إذا كان المستخدم أمين مكتبة
    if ($librarian && password_verify($password, $librarian['password'])) {
        // إذا كانت البيانات صحيحة، يتم تخزين معرف المستخدم في الجلسة
        $_SESSION['user_id'] = $librarian['id'];
        $_SESSION['role'] = 'librarian'; // تعيين الدور كـ أمين مكتبة

        header("Location: librarians-page.php"); // إعادة التوجيه إلى صفحة أمين المكتبة
        exit;
    }

    // التحقق من بيانات الدخول في جدول الطلاب (أو غيره)
    $stmtStudent = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmtStudent->execute([$email]);
    $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

    if ($student && password_verify($password, $student['password'])) {
        // إذا كانت البيانات صحيحة، يتم تخزين معرف المستخدم في الجلسة
        $_SESSION['user_id'] = $student['id'];
        $_SESSION['role'] = 'student'; // تعيين الدور كـ طالب

        header("Location: index.php"); // إعادة التوجيه إلى لوحة تحكم الطالب
        exit;
    } else {
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

    <nav>
   
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="login-librarian.php">Librarian Login</a>
    </nav>

    <div class="container">
        <h1>Login</h1>

        <?php if (!empty($message)) { echo "<div class='message'>$message</div>"; } ?>

        <div class="form-container">
            <h2>Login</h2>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
