
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
            window.location.href = tasksIndexUrl;
  
          })
          .catch(function(error) {
            console.error("Error:", error);
          });
  
  
      });


      $(document).ready(function() {
        $('#client').change(function() {
            var selectedClientId = $(this).val();
            // Здесь вы можете выполнить AJAX-запрос к серверу для получения данных о контакте клиента на основе выбранного идентификатора клиента
            // Например:
            $.ajax({
            url: '/getClientContactInfo',
            type: 'GET',
            data: { clientId: selectedClientId },
            success: function(response) {
                // Здесь вы можете обновить значения полей формы на основе полученных данных
                $('#fullname').val(response.fullname);
                $('#phone').val(response.phone);
                $('#email').val(response.email);
            },
            error: function(xhr, status, error) {
                // Обработка ошибок
            }
            });
        });
        });