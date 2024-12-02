<?php
header('Content-Type: application/json');

// Перевіряємо метод запиту
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Діагностика: отримуємо ID
$id = intval($_POST['id'] ?? 0);
file_put_contents('log.txt', "Отриманий ID: $id\n", FILE_APPEND); // Запис у файл

if ($id <= 0) {
    echo json_encode(['error' => 'Invalid ID']);
    exit;
}

// Параметри підключення до бази даних
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'web';

// Підключаємося до бази даних
$conn = new mysqli($host, $username, $password, $database);

// Перевіряємо підключення
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Виконуємо запит на видалення
$stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'No user found with the given ID']);
    }
} else {
    echo json_encode(['error' => 'Error executing query: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
