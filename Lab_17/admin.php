<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Регулярний вираз для перевірки валідності IP-адреси
  $ipRegex = "/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/";

  // Отримання значень з форми
  $username = $_POST['username'];
  $password = $_POST['password'];
  $ip_address = $_POST['ip_address'];
  $agree = isset($_POST['agree']) ? "Згоден" : "Не згоден";
  $newsletter = isset($_POST['newsletter']) ? $_POST['newsletter'] : "Не підписаний";

  // Перевірка IP-адреси
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ipRegex = "/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/";
    $ip_address = $_POST['ip_address'];
  
    if (empty($ip_address)) {
      echo "<span style='color: red;'>Поле IP-адреси порожнє. Введіть адресу!</span>";
    } elseif (!preg_match($ipRegex, $ip_address)) {
      echo "<span style='color: red;'>IP-адреса <strong>$ip_address</strong> недійсна. Перевірте формат!</span>";
    } else {
      echo "<span style='color: green;'>IP-адреса <strong>$ip_address</strong> є валідною!</span>";
    }
  } else {
    echo "<span style='color: red;'>Дані не передано!</span>";
  }
}
?>