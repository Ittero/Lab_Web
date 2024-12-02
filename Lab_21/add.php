<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$host = 'localhost'; // Або ваш хост
$dbname = 'web'; // Ім'я бази даних
$user = 'root'; // Ім'я користувача
$password = 'root'; // Пароль для доступу

try {
    // Підключення до бази
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Отримуємо JSON-дані
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['name'], $input['email'], $input['age'])) {
        $name = $input['name'];
        $email = $input['email'];
        $age = $input['age'];

        // Перевірка даних
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Некоректний email']);
            exit;
        }

        // Додаємо запис у базу
        $stmt = $pdo->prepare("INSERT INTO users (name, email, age) VALUES (:name, :email, :age)");
        $stmt->execute(['name' => $name, 'email' => $email, 'age' => $age]);

        echo json_encode(['success' => true, 'message' => 'Запис додано успішно!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Неправильні дані']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Помилка бази даних: ' . $e->getMessage()]);
}
