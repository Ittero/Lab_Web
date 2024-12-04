<?php
header('Content-Type: application/json');

// Перевіряємо метод запиту
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Отримуємо ID користувача
$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['error' => 'Invalid ID']);
    exit;
}

// Діагностика: запис ID в лог-файл для перевірки
file_put_contents('log.txt', "Отриманий ID: $id\n", FILE_APPEND);

// Параметри підключення до бази даних
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'web';

// Підключення до бази даних
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Видалення користувача
$stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Користувача видалено успішно!']);
    } else {
        echo json_encode(['error' => 'Користувач із вказаним ID не знайдений.']);
    }
} else {
    echo json_encode(['error' => 'Помилка запиту: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>