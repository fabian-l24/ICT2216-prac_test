<?php
$searchTerm = $_GET['search'] ?? '';
$cleanTerm = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="en" xml:lang="en">
<head>
    <title>Search Result</title>
</head>
<body>
    <h1>Search Term</h1>
    <p>You searched for: <strong><?= $cleanTerm ?></strong></p>
    <form action="index.php" method="get">
        <button type="submit">Return to Home</button>
    </form>
</body>
</html>
