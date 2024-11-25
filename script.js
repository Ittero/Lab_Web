
// Lab 13
document.getElementById('monthForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const month = document.getElementById('monthInput').value;
    // Відправка даних на сервер
    const response = await fetch('admin.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `month=${encodeURIComponent(month)}`,
    });
    // Обробка відповіді
    const message = await response.text();
    alert(message);
  });

// lab 14
function fetchPHP() {
    fetch('./admin.php') 
      .then(response => {
        if (!response.ok) {
          throw new Error('Помилка з сервером');
        }
        return response.text();
      })
      .then(data => {
        document.getElementById('output').innerHTML = data;
      })
      .catch(error => {
        console.error('Сталася помилка:', error);
      });
  }

//   Lb 15

