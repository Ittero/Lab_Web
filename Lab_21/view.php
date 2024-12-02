<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "web";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Помилка підключення: " . $conn->connect_error);
}

// Отримання даних
$sql = "SELECT name, age FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }
}

echo json_encode($users);

$conn->close();
?>
