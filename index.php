<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

// التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
session_start();

// إذا لم يكن المستخدم قد سجل الدخول، يتم إعادة توجيهه إلى صفحة تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// استرجاع بيانات المستخدم
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email FROM students WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// عرض رسالة ترحيبية
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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
        <a href="logout.php">Logout</a>
    </nav>

    <div class="welcome-container">
        <h1>Welcome to the Digital Library Management System</h1>

        <p>Hello, <strong><?php echo htmlspecialchars($user['name']); ?></strong>! Welcome to your personal dashboard.</p>
        
        <p>Explore books, borrow them, and much more!</p>

    </div>
</body>
</html>
