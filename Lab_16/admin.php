<?php
// Початкова матриця C
$matrixC = [
    [11.3, -7.2, 4.1],
    [8.4, -3.7, 1.7],
    [8.3, 18.4, 13.7]
];

// Ініціалізація змінних
$minNegative = null;
$minCoordinates = [];
$newMatrix = [];
$positiveCoordinates = [];
$positiveCount = 0;
$positiveSum = 0;
$productOfNegatives = 1;

// Знаходимо мінімальний від'ємний елемент та його координати
foreach ($matrixC as $i => $row) {
    foreach ($row as $j => $value) {
        if ($value < 0 && ($minNegative === null || $value < $minNegative)) {
            $minNegative = $value;
            $minCoordinates = [$i, $j];
        }
    }
}

// Обчислюємо нову матрицю та аналізуємо її
foreach ($matrixC as $i => $row) {
    $newRow = [];
    foreach ($row as $j => $value) {
        $newValue = $value * $minNegative;
        $newRow[] = $newValue;

        if ($newValue > 0) {
            $positiveCount++;
            $positiveSum += $newValue;
            $positiveCoordinates[] = [$i, $j];
        } elseif ($newValue < 0) {
            $productOfNegatives *= $newValue;
        }
    }
    $newMatrix[] = $newRow;
}

// Середнє значення додатних елементів
$positiveAverage = $positiveCount > 0 ? $positiveSum / $positiveCount : 0;

// Корінь кубічний з добутку від’ємних елементів
$cubicRoot = $productOfNegatives < 0 ? -pow(abs($productOfNegatives), 1/3) : pow($productOfNegatives, 1/3);

// Виведення результатів
echo "<h2>Масив:</h2>";
echo "<img src='../images/two_masyv.png' alt='Масив'>";

echo "<h3>Мінімальний від'ємний елемент:</h3> <p>$minNegative (координати: [" . implode(", ", $minCoordinates) . "])</p>";

echo "<h3>Нова матриця:</h3>";
echo "<table border='1' style='border-collapse: collapse; text-align: center; justify-content: center; display: flex;'>";
foreach ($newMatrix as $row) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>" . round($value, 2) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo "<h3>Кількість додатних елементів:</h3> <p>$positiveCount</p>";
echo "<h3>Координати додатних елементів:</h3>";
foreach ($positiveCoordinates as $coord) {
    echo "<p>[" . implode(", ", $coord) . "]</p>";
}

echo "<h3>Середнє значення додатних елементів:</h3> <p>" . round($positiveAverage, 2) . "</p>";
echo "<h3>Добуток від'ємних елементів:</h3> <p>" . round($productOfNegatives, 2) . "</p>";
echo "<h3>Корінь кубічний з добутку від'ємних:</h3> <p>" . round($cubicRoot, 2) . "</p>";
?>
