const form = document.getElementById('monthForm');
const resultDiv = document.getElementById('result');

form.addEventListener('submit', async (e) => {
  e.preventDefault(); // Забороняємо стандартне відправлення форми
  const month = document.getElementById('monthInput').value;

  // Показуємо статус завантаження
  resultDiv.innerHTML = '<span class="loading">Завантаження...</span>';

  try {
    // Відправка запиту на сервер
    const response = await fetch('admin.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `month=${encodeURIComponent(month)}`,
    });

    // Отримання відповіді від сервера
    const text = await response.text();
    resultDiv.innerHTML = text; // Виводимо результат
  } catch (error) {
    resultDiv.innerHTML = '<span style="color: red;">Сталася помилка. Спробуйте ще раз.</span>';
  }
});