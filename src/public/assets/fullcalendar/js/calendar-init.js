// Открыть модальное окно при нажатии на кнопку "Add"
document.getElementById("openModalBtn").addEventListener("click", function() {
  document.getElementById("myModal").style.display = "block";
});

// Закрыть модальное окно при нажатии на крестик
document.querySelector("#myModal .close").addEventListener("click", function() {
  document.getElementById("myModal").style.display = "none";
});

// Закрыть модальное окно при клике за его пределами
window.addEventListener("click", function(event) {
  if (event.target === document.getElementById("myModal")) {
    document.getElementById("myModal").style.display = "none";
  }
});

// Обработчик отправки формы
document.getElementById("taskForm").addEventListener("submit", function(event) {
  event.preventDefault();
  var form = this;
  var formData = new FormData(form);

  fetch(form.action, {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      form.reset();
      closeModal();
      alert("Data saved successfully!");
      window.location.href = "{{ route('erp.manager.tasks.index') }}";
    })
    .catch(error => {
      console.error("Error:", error);
    });
});

// Закрыть модальное окно при нажатии на крестик или кнопку "Закрыть"
document.querySelectorAll("#myModal .close, #myModal .btn-close").forEach(function(element) {
  element.addEventListener("click", function() {
    closeModal();
  });
});

// Закрыть модальное окно при клике за его пределами
window.addEventListener("click", function(event) {
  if (event.target === document.getElementById("myModal")) {
    closeModal();
  }
});

// Функция для закрытия модального окна
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

















// Функция для открытия модального окна
function openModal() {
  document.getElementById("myModal").style.display = "block";
}

// Функция для закрытия модального окна
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

// Открыть модальное окно при нажатии на кнопку "Add"
document.getElementById("openModalBtn").addEventListener("click", function() {
  openModal();
});

// Закрыть модальное окно при нажатии на крестик или кнопку "Закрыть"
document.querySelectorAll("#myModal .close, #myModal .btn-close").forEach(function(element) {
  element.addEventListener("click", function() {
    closeModal();
  });
});

// Закрыть модальное окно при клике за его пределами
window.addEventListener("click", function(event) {
  if (event.target === document.getElementById("myModal")) {
    closeModal();
  }
});

// Обработчик отправки формы
document.getElementById("taskForm").addEventListener("submit", function(event) {
  event.preventDefault();
  var form = this;
  var formData = new FormData(form);

  fetch(form.action, {
    method: "POST",
    body: formData
  })
    .then(function() {
      form.reset();
      closeModal();
      alert("Data saved successfully!");
      window.location.href = "{{ route('erp.manager.tasks.index') }}";
    })
    .catch(function(error) {
      console.error("Error:", error);
    });
});
