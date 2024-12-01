<?php
// Масив B
$arrayB = array(5, 4, 7, 6, -3, -2, -5, 0, 9, -5);

// Обчислення суми квадратів від'ємних елементів
$sumNegativeSquares = 0;
$negativeCount = 0;
$positiveCount = 0;

foreach ($arrayB as $value) {
    if ($value < 0) {
        $sumNegativeSquares += $value ** 2;
        $negativeCount++;
    } elseif ($value > 0) {
        $positiveCount++;
    }
}

// Модифікація масиву B
$factor = $sumNegativeSquares > 200 ? $negativeCount : $positiveCount;
$newArray = array_map(function ($value) use ($factor) {
    return $value * $factor;
}, $arrayB);

// Обчислення добутку, координат і кількості елементів більше за 25
$product = 0;
$countGreaterThan25 = 0;
$coordinates = [];

foreach ($newArray as $index => $value) {
    if ($value > 25) {
        $product += $value;
        $countGreaterThan25++;
        $coordinates[] = $index+1;
    }
}

// Виведення результатів у вигляді таблиці
echo "<h2>Масив:</h2>";
echo "<img src='../images/Masyv.png' alt='Масив'>";

echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>
        <thead>
            <tr>
                <th>Параметр</th>
                <th>Значення</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Сума квадратів від'ємних</td>
                <td>$sumNegativeSquares</td>
            </tr>
            <tr>
                <td>Кількість від'ємних елементів</td>
                <td>$negativeCount</td>
            </tr>
            <tr>
                <td>Кількість додатних елементів</td>
                <td>$positiveCount</td>
            </tr>
            <tr>
                <td>Модифікований масив</td>
                <td>" . implode(', ', $newArray) . "</td>
            </tr>";

if ($countGreaterThan25 > 0) {
    echo "<tr>
            <td>Добуток елементів > 25</td>
            <td>$product</td>
          </tr>
          <tr>
            <td>Координати елементів > 25</td>
            <td>" . implode(', ', $coordinates) . "</td>
          </tr>
          <tr>
            <td>Кількість елементів > 25</td>
            <td>$countGreaterThan25</td>
          </tr>";
} else {
    echo "<tr>
            <td colspan='2'>Елементів > 25 немає.</td>
          </tr>";
}

echo "  </tbody>
      </table>";
?>
