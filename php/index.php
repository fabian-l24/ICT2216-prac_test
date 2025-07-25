<?php
function isXSS($input) {
    return $input !== htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

function isSQLInjection($input) {
    $patterns = [
        '/(\%27)|(\')|(\-\-)|(\%23)|(#)/i',            // SQL meta characters
        '/\b(select|insert|update|delete|drop|union|--)\b/i' // SQL keywords
    ];
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return true;
        }
    }
    return false;
}

$searchTerm = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = trim($_POST['search'] ?? '');

    if (isXSS($searchTerm)) {
        $error = 'Potential XSS detected. Please enter a valid search term.';
        $searchTerm = '';
    } elseif (isSQLInjection($searchTerm)) {
        $error = 'Potential SQL Injection detected. Please enter a valid search term.';
        $searchTerm = '';
    } else {
        // Safe input, redirect with query param
        header("Location: result.php?search=" . urlencode($searchTerm));
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Page</title>
</head>
<body>
    <h1>Search</h1>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="search" value="<?= htmlspecialchars($searchTerm, ENT_QUOTES) ?>" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
