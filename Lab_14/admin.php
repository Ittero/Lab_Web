<?php
// Вхідні дані
$a = [1, 3, 5, 7, 9, 11, 13, 15, 17, 19];
$b = [2, 6, 10, 14, 18, 22, 26, 30, 34, 38];
$c = [46, 41, 36, 31, 26, 21, 16, 11, 6, 1];
$x = [4, 7, 10, 13, 16, 19, 22, 25, 28, 31];

// Параметри для розмірів та кольорів
$variant = 4; // Номер варіанту
$height = $variant * 3;
$width = $variant * 5;
$bgColor = $variant * 10;
$borderColor = $variant * 15;

echo "<h2>Формула:</h2>";
echo "<img src='../images/formula.png' alt='Формула'>";

echo "<h2>Результати табуляції:</h2>";

// Цикли для обчислення
for ($i = 0; $i < count($a); $i++) {
    $y = pow($a[$i], 2) * pow(sin($x[$i]), 2) + $b[$i] * $x[$i] - sin($b[$i]) + asin($x[$i] / ($b[$i] + $c[$i]));

    // Обчислення кольорів
    $currentBgColor = dechex(($bgColor + $i * 7) % 256);
    $currentBorderColor = dechex(($borderColor + $i * 7) % 256);

    // Формат кольорів (RGB)
    $bgColorHex = "#" . str_pad($currentBgColor, 6, "0", STR_PAD_LEFT);
    $borderColorHex = "#" . str_pad($currentBorderColor, 6, "0", STR_PAD_LEFT);

    // Виведення результату в div
    echo "<div style='
        background-color: $bgColorHex;
        border: 2px solid $borderColorHex;
        width: {$width}px;
        height: {$height}px;
        margin: 10px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;'>
        y = " . round($y, 2) . "
    </div>";

    // Збільшення розмірів блоку
    $height += 5;
    $width += 10;
}