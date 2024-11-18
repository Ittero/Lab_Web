<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = $_POST['month'];
    $message = '';

    switch ($month) {
        case 1:
            $message = "Січень - Зима";
            break;
        case 2:
            $message = "Лютий - Зима";
            break;
        case 3:
            $message = "Березень - Весна";
            break;
        case 4:
            $message = "Квітень - Весна";
            break;
        case 5:
            $message = "Травень - Весна";
            break;
        case 6:
            $message = "Червень - Літо";
            break;
        case 7:
            $message = "Липень - Літо";
            break;
        case 8:
            $message = "Серпень - Літо";
            break;
        case 9:
            $message = "Вересень - Осінь";
            break;
        case 10:
            $message = "Жовтень - Осінь";
            break;
        case 11:
            $message = "Листопад - Осінь";
            break;
        case 12:
            $message = "Грудень - Зима";
            break;
        default:
            $message = "Місяця з таким номером на Землі не існує.";
    }

    echo $message; // Повертаємо відповідь
}
?>
