<?php
require_once __DIR__ . '/vendor/autoload.php'; // Composer autoloader

use App\Validator;

$searchTerm = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = trim($_POST['search'] ?? '');

    if (Validator::isXSS($searchTerm)) {
        $error = 'Potential XSS detected. Please enter a valid search term.';
        $searchTerm = '';
    } elseif (Validator::isSQLInjection($searchTerm)) {
        $error = 'Potential SQL Injection detected. Please enter a valid search term.';
        $searchTerm = '';
    } else {
        header("Location: result.php?search=" . urlencode($searchTerm));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en" xml:lang="en">
<head>
    <title>Search Page</title>
</head>
<body>
    <h1>Search</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="search" value="<?= htmlspecialchars($searchTerm) ?>" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
