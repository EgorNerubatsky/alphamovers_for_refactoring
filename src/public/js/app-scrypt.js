

  $(function () {
    //Initialize Select2 Elements
    // $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })


    $(document).ready(function() {
        console.log("jQuery is ready!");
    });



    $(document).ready(function() {
        console.log("jQuery is ready!");

        $('#client').change(function() {
            console.log("Client value changed!");

            var selectedClientId = $(this).val();

            $.ajax({
                url: '/getClientContactInfo',
                type: 'GET',
                data: { clientId: selectedClientId },
                success: function(response) {
                    console.log("AJAX request successful!");
                    console.log(response);

                    $('#fullname').val(response.fullname);
                    $('#phone').val(response.phone);
                    $('#email').val(response.email);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed!");
                    console.error(xhr, status, error);
                }
            });
        });
    });






        document.addEventListener('DOMContentLoaded', function() {
        var field1Input = document.getElementById('price_to_customer');
        var field2Input = document.getElementById('price_to_workers');
        var minOrderSelect = document.getElementById('rate');

        minOrderSelect.addEventListener('change', function() {
            var selectedValue = minOrderSelect.value;
            var values = selectedValue.split('/');

            field1Input.value = values[0];
            field2Input.value = values[1];
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        var field1Input = document.getElementById('price_to_customer_0');
        var field2Input = document.getElementById('price_to_workers_0');
        var minOrderSelect = document.getElementById('rate_0');

        minOrderSelect.addEventListener('input', function() {
            var selectedValue = minOrderSelect.value;
            var values = selectedValue.split('/');

            field1Input.value = values[0];
            field2Input.value = values[1];
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        var field1Input = document.getElementById('price_to_customer_1');
        var field2Input = document.getElementById('price_to_workers_1');
        var minOrderSelect = document.getElementById('rate_1');

        minOrderSelect.addEventListener('input', function() {
            var selectedValue = minOrderSelect.value;
            var values = selectedValue.split('/');

            field1Input.value = values[0];
            field2Input.value = values[1];
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        var field1Input = document.getElementById('price_to_customer_2');
        var field2Input = document.getElementById('price_to_workers_2');
        var minOrderSelect = document.getElementById('rate_2');

        minOrderSelect.addEventListener('input', function() {
            var selectedValue = minOrderSelect.value;
            var values = selectedValue.split('/');

            field1Input.value = values[0];
            field2Input.value = values[1];
        });
    });

    function toggleSidebar() {
        var sidebarWrapper = document.getElementById('sidebar-wrapper');
        var contentWrapper = document.getElementById('content-wrapper');
        var isSidebarHidden = localStorage.getItem('sidebarHidden') === 'true';

        if (isSidebarHidden) {
            sidebarWrapper.style.display = 'block';
            contentWrapper.style.marginLeft = '200px';
        } else {
            sidebarWrapper.style.display = 'none';
            contentWrapper.style.marginLeft = '0';
        }

        // Сохранение состояния боковой панели в localStorage
        localStorage.setItem('sidebarHidden', !isSidebarHidden);
    }

    // Проверка состояния боковой панели при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        var sidebarWrapper = document.getElementById('sidebar-wrapper');
        var contentWrapper = document.getElementById('content-wrapper');
        var isSidebarHidden = localStorage.getItem('sidebarHidden') === 'true';

        if (isSidebarHidden) {
            sidebarWrapper.style.display = 'none';
            contentWrapper.style.marginLeft = '0';
        } else {
            sidebarWrapper.style.display = 'block';
            contentWrapper.style.marginLeft = '200px';
        }
    });
























    function updateFileName(input, labelId) {
        var fileNameLabel = document.getElementById(labelId);
        fileNameLabel.textContent = input.files[0].name;
    }




    document.getElementById('select-all-leads').addEventListener('change', function() {
        var checkboxes = document.getElementsByName('selected_leads[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });

    document.getElementById('select_all_emails').addEventListener('change', function() {
        var checkboxes = document.getElementsByName('selected_emails[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var modal = document.getElementById('editModal');
                $(modal).modal('show');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var cancelButton = document.querySelector('#editModal .modal-footer .btn-secondary');
        var saveButton = document.querySelector('#editModal .modal-footer #saveButton');

        cancelButton.addEventListener('click', function() {
            var modal = document.getElementById('editModal');
            $(modal).modal('hide');
        });

        saveButton.addEventListener('click', function() {
            var modal = document.getElementById('editModal');
            $(modal).modal('hide');
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        var tableRows = document.querySelectorAll("tr[data-target]");

        tableRows.forEach(function(row) {
            var clickCount = 0;
            var timer;

            row.addEventListener("click", function() {
                clickCount++;
                if (clickCount === 1) {
                    timer = setTimeout(function() {
                        clickCount = 0;
                    }, 300);
                } else if (clickCount === 2) {
                    clearTimeout(timer);
                    clickCount = 0;
                    var target = row.getAttribute("data-target");
                    var modal = document.querySelector(target);
                    if (modal) {
                        modal.classList.add("show");
                        modal.style.display = "block";
                        document.body.classList.add("modal-open");

                        // Обработчик события нажатия на кнопку "Esc"
                        document.addEventListener("keydown", function(event) {
                            if (event.key === "Escape") {
                                closeModal(modal);
                            }
                        });

                        // Обработчик события нажатия на кнопку "Cancel"
                        var cancelButton = modal.querySelector(".modal-footer .btn-secondary");
                        if (cancelButton) {
                            cancelButton.addEventListener("click", function() {
                                closeModal(modal);
                            });
                        }

                        var closeButton = modal.querySelector(".modal-header .close");
        if (closeButton) {
            closeButton.addEventListener("click", function() {
                closeModal(modal);
            });
        }

                            // Обработчик события нажатия на кнопку "Esc"
                    document.addEventListener("keydown", function(event) {
                        if (event.key === "Escape") {
                            closeModal(modal);
                        }
        });
                    }
                }

            });
        });

        // Функция для закрытия модального окна
        function closeModal(modal) {
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }

    });

    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var modal = document.getElementById('editModal2');
                $(modal).modal('show');
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        var cancelButton = document.querySelector('#editModal2 .modal-footer .btn-secondary');
        var saveButton = document.querySelector('#editModal2 .modal-footer #saveButton');

        cancelButton.addEventListener('click', function() {
            var modal = document.getElementById('editModal2');
            $(modal).modal('hide');
        });

        saveButton.addEventListener('click', function() {
            var modal = document.getElementById('editModal2');
            $(modal).modal('hide');
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var modal = document.getElementById('editModal3');
                $(modal).modal('show');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var cancelButton = document.querySelector('#editModal3 .modal-footer .btn-secondary');
        var saveButton = document.querySelector('#editModal3 .modal-footer #saveButton');

        cancelButton.addEventListener('click', function() {
            var modal = document.getElementById('editModal3');
            $(modal).modal('hide');
        });

        saveButton.addEventListener('click', function() {
            var modal = document.getElementById('editModal3');
            $(modal).modal('hide');
        });
    });






    // Функция для проверки, был ли загружен файл
    function isFileUploaded(inputId) {
        var fileInput = document.getElementById(inputId);
        return fileInput.files && fileInput.files.length > 0;
    }

    // Функция для установки атрибута required в зависимости от загруженного файла
    function toggleExecutionDateRequired(inputId, selectId) {
        var executionDateInput = document.getElementById(selectId);
        if (isFileUploaded(inputId)) {
            executionDateInput.setAttribute('required', 'required');
        } else {
            executionDateInput.removeAttribute('required');
        }
    }

    // Обновляем состояние атрибута required при изменении файла
    document.getElementById('deed_file').addEventListener('change', function () {
        toggleExecutionDateRequired('deed_file', 'order_execution_date_deed');
    });
    document.getElementById('invoice_file').addEventListener('change', function () {
        toggleExecutionDateRequired('invoice_file', 'order_execution_date_invoice');
    });
    document.getElementById('act_file').addEventListener('change', function () {
        toggleExecutionDateRequired('act_file', 'order_execution_date_act');
    });

    // Инициализируем состояние атрибута required при загрузке страницы
    window.addEventListener('load', function () {
        toggleExecutionDateRequired('deed_file', 'order_execution_date_deed');
        toggleExecutionDateRequired('invoice_file', 'order_execution_date_invoice');
        toggleExecutionDateRequired('act_file', 'order_execution_date_act');
    });



// Функция для открытия модального окна

// Функция для открытия модального окна
















    // Get articles to the checkboxes
    const maleCheckbox = document.getElementById('male');
    const femaleCheckbox = document.getElementById('female');

    // Add event listeners to the checkboxes
    maleCheckbox.addEventListener('change', function() {
        if (this.checked) {
            // If the male checkbox is checked, disable the female checkbox
            femaleCheckbox.disabled = true;
        } else {
            // If the male checkbox is unchecked, enable the female checkbox
            femaleCheckbox.disabled = false;
        }
    });

    femaleCheckbox.addEventListener('change', function() {
        if (this.checked) {
            // If the female checkbox is checked, disable the male checkbox
            maleCheckbox.disabled = true;
        } else {
            // If the female checkbox is unchecked, enable the male checkbox
            maleCheckbox.disabled = false;
        }
    });


    function setupModal(modalId) {
        var modal = document.getElementById(modalId);
        var orderIdInput = modal.querySelector('#order_id');

        // Обработчик открытия модального окна
        $('body').on('show.bs.modal', '.modal', function (event) {
            var button = $(event.relatedTarget); // Кнопка, которая вызвала модальное окно
            var orderId = button.data('order-id'); // Получаем значение data-order-id из кнопки
            $('#order_id').val(orderId); // Передаем значение в скрытое поле
        });

        // Обработчик сохранения
        var saveButton = modal.querySelector('.modal-footer #saveButton');
        saveButton.addEventListener('click', function() {
            var orderId = orderIdInput.value;
            // Здесь можно использовать orderId для отправки данных на сервер или выполнения других действий
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var modalPrefix = 'addMoverModal_';
        var numberOfModals = 100000; // Замените на количество ваших модальных окон

        for (var i = 1; i <= numberOfModals; i++) {
            setupModal(modalPrefix + i);
        }
    });


  // Chart.js
//   var ctx = document.getElementById('myChart').getContext('2d');

//   // Создайте график
//   var myChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//       labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн'],
//       datasets: [{
//         label: 'Продажи',
//         data: [12, 19, 3, 5, 2, 3],
//         backgroundColor: 'rgba(75, 192, 192, 0.2)',
//         borderColor: 'rgba(75, 192, 192, 1)',
//         borderWidth: 1
//       },
//       {
//         label: 'Прибыль',
//         data: [8, 12, 5, 10, 6, 8],
//         backgroundColor: 'rgba(255, 99, 132, 0.2)',
//         borderColor: 'rgba(255, 99, 132, 1)',
//         borderWidth: 1
//       }]
//     },
//     options: {
//       scales: {
//         y: {
//           beginAtZero: true
//         }
//       }
//     }
//   });



    document.getElementById('toggleThemeBtn').addEventListener('click', function() {
    // Переключение темы
    document.body.classList.toggle('dark-mode');

    // Сохранение состояния темы в localStorage
    const isDarkModeEnabled = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkModeEnabled);

});

    // Проверка состояния темы при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkModeEnabled = localStorage.getItem('darkMode') === 'true';

        // Применение темной темы, если она сохранена
        if (isDarkModeEnabled) {
            document.body.classList.add('dark-mode');
        }
    });





  document.getElementById('emailDeleteButton').addEventListener('click', function () {
    var checkedCheckboxes = document.querySelectorAll('.icheck-primary input[type="checkbox"]:checked');

    if (checkedCheckboxes.length > 0) {
      var emailIds = Array.from(checkedCheckboxes).map(function (checkbox) {
        return checkbox.id.replace('check', '');
      });

      fetch("{{ route('erp.executive.emails.deleteEmail') }}", {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ emailIds: emailIds }),
      })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          // Add logic to update the UI or show a success message
        })
        .catch(error => console.error('Error:', error));
    }
  });

  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(_progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }


  // Ваш код для изменения поведения в зависимости от выбора файла
//   function updateFileName(input, labelId) {
//     var fileName = input.files[0].name;
//     document.getElementById(labelId).innerHTML = fileName;
//   }

//   function toggleExecutionDateRequired(input) {
//   }

  // DropzoneJS Demo Code End


    // $(document).ready(function() {
    //     // Функция для обновления почты
    //     function updateEmails() {
    //         $.ajax({
    //             url: '{{ route("erp.executive.emails.getMails") }}', // Используем ваш путь для метода getMails
    //             type: 'GET',
    //             success: function(_response) {
    //                 // Обработка успешного обновления
    //                 console.log('Почта успешно обновлена');
    //             },
    //             error: function(error) {
    //                 // Обработка ошибки обновления
    //                 console.error('Ошибка при обновлении почты', error);
    //             }
    //         });
    //     }

    //     // Запускаем обновление каждые 5 минут
    //     setInterval(function() {
    //         updateEmails();
    //     }, 300000); // 300000 миллисекунд = 5 минут
    // });






