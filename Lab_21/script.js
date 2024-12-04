function addRecord() {
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const age = document.getElementById("age").value.trim();

  if (!name || !email || !age) {
    const output = document.getElementById("output");
    output.innerHTML = '<span style="color: red;">Заповніть всі поля!</span>';
    output.style.display = "block";

    // Таймер для приховування повідомлення
    setTimeout(() => {
        output.style.display = "none";
    }, 5000);
    return;
}

fetch("add.php", {
  method: "POST",
  headers: {
      "Content-Type": "application/json",
  },
  body: JSON.stringify({ name, email, age }),
})
  .then((response) => response.json())
  .then((data) => {
      const output = document.getElementById("output");
      if (data.success) {
          output.innerHTML =
              '<span style="color: green;">Користувача успішно додано!</span>';
      } else {
          output.innerHTML =
              '<span style="color: red;">' + data.message + "</span>";
      }
      output.style.display = "block";

      setTimeout(() => {
          output.style.display = "none";
      }, 3000);

      if (data.success) {
          fetchUsers(); 
      }
  })
  .catch((error) => {
      const output = document.getElementById("output");
      output.innerHTML =
          '<span style="color: red;">Помилка сервера: ' + error + "</span>";
      output.style.display = "block";

      // Таймер для приховування повідомлення
      setTimeout(() => {
          output.style.display = "none";
      }, 5000); // Зникає через 3 секунди
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
                  <button onclick="deleteUser(${user.id})" class="button">Видалити</button>
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
    // Перевірка, чи переданий ID
    if (!userId) {
        alert("Помилка: ID користувача не переданий.");
        return;
    }

    // Підтвердження видалення
    if (!confirm("Ви дійсно хочете видалити цього користувача?")) return;

    // Відправка запиту на сервер
    fetch("./delete.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${encodeURIComponent(userId)}`,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message || "Користувача успішно видалено!");
                fetchUsers(); // Оновлення списку користувачів
            } else {
                alert(`Помилка: ${data.error || "Не вдалося видалити користувача."}`);
            }
        })
        .catch((error) => {
            alert(`Помилка: ${error.message}`);
            console.error("Деталі помилки:", error);
        });
}
