<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

$searchResults = [];

if (isset($_GET['search']) && isset($_GET['query'])) {
    $query = "%" . $_GET['query'] . "%";
    // تعديل الاستعلام لقبول كل القيم غير الصفرية
    $stmt = $pdo->prepare("SELECT * FROM books WHERE title LIKE ? AND available_copies > 0");
    $stmt->execute([$query]);
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="DLMS.css">
</head>
<body>
    <!-- شريط التنقل -->
    <nav>
        <a href="register_student.php">Register Student</a>
        <a href="search_books.php">Search Books</a>
        <a href="borrow_books.php">Borrow Books</a>
        <a href="dashboard.php">Dashboard</a>
        <a href=" return_book.php">Return book</a>
    </nav>

    <h1>Search E-books</h1>

    <form method="GET">
        <label for="query">Enter book title:</label>
        <input type="text" id="query" name="query" required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php
    if (!empty($searchResults)) {
        echo "<h3>Search Results:</h3><ul>";
        foreach ($searchResults as $book) {
            echo "<li>" . htmlspecialchars($book['title']) . "</li>";
        }
        echo "</ul>";
    } elseif (isset($_GET['search'])) {
        echo "<p>No books found.</p>";
    }
    ?>
</body>
</html>
