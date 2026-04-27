<?php
    require_once 'db.php';

    $number = $_POST['number'] ?? 0; 
    $number_of_colors = $_POST['number_of_colors'] ?? 0;
    $isValid = true;

    $result = $conn->query("SELECT id, name, hex_value FROM colors ORDER BY id");
    $allColors = $result->fetch_all(MYSQLI_ASSOC);
    $maxColors = count($allColors);

    if ($number < 1 || $number > 26)                          $isValid = false;
    if ($number_of_colors < 1 || $number_of_colors > $maxColors) $isValid = false;

    $colorNames = $_POST['colorNames'] ?? [];
    $colorHexes = $_POST['colorHexes'] ?? [];
    $coordLists = $_POST['coordLists'] ?? [];

    $alphabet = range('A', 'Z');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Pushers — Print View</title>
    <link rel="stylesheet" href="./style/print.css">
</head>
<body>
<div class="container">
    <img src="./images/Logo.jpg" alt="Pixel Pushers Logo" class="logo">
    <h1>Pixel Pushers</h1>
    <p>Professional Color Coordination Tools — Printable View</p>

    <?php if ($isValid): ?>

    <h2>Color Selection</h2>
    <table class="colorlist">
        <tr>
            <th>Color</th>
            <th>Coordinates</th>
        </tr>
        <?php for ($i = 0; $i < $number_of_colors; $i++): ?>
        <tr>
            <td class="colors">
                <?= htmlspecialchars($colorNames[$i] ?? 'Unknown') ?> — <?= htmlspecialchars($colorHexes[$i] ?? '') ?>
            </td>
            <td class="positions">
                <?= htmlspecialchars($coordLists[$i] ?? '') ?>
            </td>
        </tr>
        <?php endfor; ?>
        <h1>Coordinate Grid</h1>
        <table class="grid">
            <?php for($n = 0; $n < $number + 1; $n++): ?>
                <tr>
                <?php for($col = 0; $col < $number + 1; $col++): ?>
                    <?php if($n === 0 && $col === 0): ?>
                        <td> </td>
                    <?php endif; ?>
                    <?php if ($n === 0 && $col != 0): ?>
                        <td> <?php echo $alphabet[$col - 1] ?>
                    <?php endif; ?>
                    <?php if ($col === 0 && $n != 0): ?>
                        <td><?php echo $n ?>
                    <?php endif; ?>
                    <?php if ($n != 0 && $col < $number): ?>
                        <td></td>
                    <?php endif; ?>                    
                <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>
        <?php endif; ?>
    
</body>
</html>
    