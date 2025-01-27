<?php
include 'database.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return'])) {
    $borrow_id = $_POST['borrow_id'];

    // Update the borrow record with the return date
    $stmt = $pdo->prepare("UPDATE borrows SET returned_at = NOW() WHERE id = ?");
    $stmt->execute([$borrow_id]);

    // Increment the available copies for the book
    $stmtBook = $pdo->prepare("
        UPDATE books 
        SET available_copies = available_copies + 1
        WHERE id = (SELECT book_id FROM borrows WHERE id = ?)
    ");
    $stmtBook->execute([$borrow_id]);

    $message = "Book returned successfully!";
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
        <a href="register_student.php">Register Student</a>
        <a href="search_books.php">Search Books</a>
        <a href="borrow_books.php">Borrow Books</a>
        <a href="dashboard.php">Dashboard</a>
        <a href=" return_book.php">Return book</a>
    </nav>

<h1>Return Borrowed Book</h1>

<?php if (!empty($message)) { echo "<p><strong>$message</strong></p>"; } ?>

<form method="POST">
    <label for="borrow_id">Select Borrowed Book:</label>
    <select id="borrow_id" name="borrow_id" required>
        <?php
        $stmt = $pdo->query("
            SELECT borrows.id, books.title 
            FROM borrows
            JOIN books ON borrows.book_id = books.id
            WHERE borrows.returned_at IS NULL
        ");
        while ($borrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value=\"" . htmlspecialchars($borrow['id']) . "\">" . htmlspecialchars($borrow['title']) . "</option>";
        }
        ?>
    </select>
    <button type="submit" name="return">Return Book</button>
</form>
</body>
</html>