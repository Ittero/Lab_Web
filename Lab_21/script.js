function addRecord() {
    // Отримуємо значення з полів вводу
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const age = document.getElementById("age").value.trim();
  
    // Перевірка, щоб всі поля були заповнені
    if (!name || !email || !age) {
      document.getElementById("output").innerHTML =
        '<span style="color: red;">Заповніть всі поля!</span>';
      return;
    }
  
    // Створюємо запит на сервер
    fetch("add.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ name, email, age }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          document.getElementById("output").innerHTML =
            '<span style="color: green;">' + data.message + "</span>";
        } else {
          document.getElementById("output").innerHTML =
            '<span style="color: red;">' + data.message + "</span>";
        }
      })
      .catch((error) => {
        document.getElementById("output").innerHTML =
          '<span style="color: red;">Помилка сервера: ' + error + "</span>";
      });
  }
  
  function fetchUsers() {
    fetch('./view.php')
      .then(response => response.json())
      .then(data => {
        if (data.length === 0) {
          document.getElementById('users-table').innerHTML = '<span style="color: gray;">Немає зареєстрованих користувачів.</span>';
          return;
        }
  
        // Генерація таблиці
        const table = `
          <table border="1" style="width: 100%; text-align: center;">
            <thead>
              <tr>
                <th onclick="sortUsers('name')">Ім'я</th>
                <th onclick="sortUsers('age')">Вік</th>
              </tr>
            </thead>
            <tbody id="users-body">
              ${data.map(user => `<tr><td>${user.name}</td><td>${user.age}</td></tr>`).join('')}
            </tbody>
          </table>`;
        document.getElementById('users-table').innerHTML = table;
      })
      .catch(error => {
        document.getElementById('users-table').innerHTML = '<span style="color: red;">Помилка: ' + error + '</span>';
      });
  }
  
  // Сортування користувачів
  let currentSort = { key: null, ascending: true };
  function sortUsers(key) {
    fetch('./view.php')
      .then(response => response.json())
      .then(data => {
        if (currentSort.key === key) {
          currentSort.ascending = !currentSort.ascending;
        } else {
          currentSort.key = key;
          currentSort.ascending = true;
        }
  
        data.sort((a, b) => {
          if (a[key] < b[key]) return currentSort.ascending ? -1 : 1;
          if (a[key] > b[key]) return currentSort.ascending ? 1 : -1;
          return 0;
        });
  
        document.getElementById('users-body').innerHTML = data
          .map(user => `<tr><td>${user.name}</td><td>${user.age}</td></tr>`)
          .join('');
      });
  }
  
  function fetchUsers() {
    fetch('./view.php')
      .then(response => {
        if (!response.ok) {
          throw new Error('Помилка сервера');
        }
        return response.json();
      })
      .then(data => {
        const usersTable = document.getElementById('users-table');
        if (!usersTable) {
          console.error('Елемент users-table не знайдено.');
          return;
        }
  
        if (data.error) {
          usersTable.innerHTML = `<span style="color: red;">${data.error}</span>`;
          return;
        }
  
        if (data.length === 0) {
          usersTable.innerHTML = '<span style="color: gray;">Немає зареєстрованих користувачів.</span>';
          return;
        }
  
        const table = `
          <table border="1" style="width: 100%; text-align: center;">
            <thead>
              <tr>
                <th onclick="sortUsers('name')">Ім'я</th>
                <th onclick="sortUsers('age')">Вік</th>
                <th>Дії</th>
              </tr>
            </thead>
            <tbody id="users-body">
              ${data
                .map(
                  user => `
                <tr>
                  <td>${user.name}</td>
                  <td>${user.age}</td>
                  <td>
                  <tr>
                  <td>1</td>
                  <td>Ім'я Користувача</td>
                  <td>
                    <button onclick="console.log('ID:', ${user.id}); deleteUser(${user.id})" class="button">Видалити</button>
                  </td>
                </tr>
                
                  </td>
                </tr>`
                )
                .join('')}
            </tbody>
          </table>`;
        usersTable.innerHTML = table;
      })
      .catch(error => {
        const usersTable = document.getElementById('users-table');
        if (usersTable) {
          usersTable.innerHTML = `<span style="color: red;">Помилка: ${error.message}</span>`;
        } else {
          console.error('Елемент users-table не знайдено.');
        }
      });
  }
  
  function deleteUser(userId) {
    console.log('ID передано в deleteUser:', userId); // Перевірка ID
  
    if (!userId) {
      console.error('ID користувача не передано!');
      return;
    }
  
    if (!confirm('Ви дійсно хочете видалити цього користувача?')) return;
  
    console.log('ID користувача:', userId); // Перевірте, чи ID передається
  
    fetch('./delete.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${encodeURIComponent(userId)}`,
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Користувача успішно видалено!');
          fetchUsers(); // Оновлення списку користувачів
        } else {
          alert(`Помилка: ${data.error}`);
        }
      })
      .catch(error => {
        alert(`Помилка: ${error.message}`);
        console.error('Деталі помилки:', error);
      });
  }
  
  