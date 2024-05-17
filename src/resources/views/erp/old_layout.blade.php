<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>AlphaMovers | {{ auth()->user()->name }}</title>

  <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <link href="{{ asset('assets/fullcalendar/css/style.css') }}" rel='stylesheet' />
    <link href="css/style.css" rel="stylesheet">


    <!-- Font Awesome -->
    <style>

    a {
        color: black; /* Цвет текста для светлой темы (по умолчанию) */
    }

    body.dark-mode a {
        color: white; /* Цвет текста для темной темы */
    }

    </style>




    <style>
        .badge:hover img {
            transform: scale(1.2); /* Увеличьте масштаб изображения, например, до 1.2 раза */
            transition: transform 0.3s ease; /* Добавьте плавное переходное анимационное свойство */
        }
    </style>


    <style>
    /* Начальные размеры картинки */


    .nav-item img {
        width: 30px;
        height: auto; /* Позволяет автоматически подстроить высоту картинки */
        transition: transform 0.3s; /* Добавляем плавный переход при изменении размера */
    }

    /* Картинка увеличивается при наведении */
    .nav-item a:hover img {
        transform: scale(1.2); /* Увеличиваем размер картинки на 20% (можете изменить значение на свой вкус) */
    }
    </style>


    <style>
        .modal-content-my {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        width: 400px;
        height: auto;
        border: 1px solid #888;
        border-radius: 20px;
        font-family: Arial, sans-serif;
        max-width: 50%;
        color: #444;
        position: absolute;
        top: -20%; /* Поднимает модальное окно к верхнему краю */
        left: 50%;
        transform: translateX(-50%);
        /* Добавьте другие стили по необходимости */
        }
    </style>


    <style>
    #editModal
      {
        /* Ширина всей зоны затемнения, она должна быть на всю видимую область */
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5);

        /* Остальные стили по мере необходимости */
    }
    </style>

    <style>

        .customm-icon {
        background-image: url('/img/navico/applicants.svg');
        /* Добавьте другие стили, такие как ширина, высота и т.д. */
        }
    </style>

    <style>
    .form-content {
        display: none;
    }

    .form-content.active {
        display: block;
    }
    </style>

    <style>
    .sidebar-hidden {
      display: none;
    }

    .content-expanded {
      width: 100% !important;
      margin-left: 0 !important;
    }

    .sidebar {
      background-color: #A9A9A9;
      /* Remove or comment out the width: 200px; */
    }

    .content-wrapper {
      /* Add the following properties */
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 0;
    }

    .content-expanded {
      /* Add the following properties */
      flex: 1;
      width: 100% !important;
      margin-left: 0 !important;
    }
  </style>


    <style>
    /* Custom CSS for the checkboxes */
    .custom-checkbox {
        width: 20px; /* Adjust the width as per your preference */
        height: 20px; /* Adjust the height as per your preference */
        margin-right: 5px; /* Adjust the spacing between the checkbox and the label */
    }
    </style>

    <style>
        .custom-active {
        background-color: #008B8B; /* Set the desired background color */
        color: white; /* Optionally, set the text color to improve visibility */
        }
        .custom-active:hover{
            background-color: #008080;
        }
    </style>




</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div id="sidebar-wrapper" >
    <aside class="main-sidebar sidebar-dark-primary elevation-4 " style="width: 200px; margin: 0;">
        <!-- Brand Logo -->
        <a href="#" class="brand-link" style="width: 200px;">
            <img src="/img/movers_logo_mini.png"
                alt="AlphamoVers Logo"
                class="brand-image img-circle elevation-3"
                >
            <span class="" style="color: white;">AlphaMovers</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
                @include('erp.menu')
        </div>
        <!-- /.sidebar -->
    </aside>
</div>



<div id="content-wrapper" style="margin-left: 200px;">
    @include('erp.navigation')

    @yield('content')
</div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 0.8.1
        </div>
        <strong>Copyright &copy; 2023 <a href="#">AlphaMovers</a>.</strong> All rights
        reserved.
    </footer>


    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>


<script>

    let index = 0;
    document.getElementById("add-date-button").addEventListener("click", function() {
        const formContainer = document.getElementById("order-details-forms");
        index++;

        const newForm = `
                        <hr class="w-100">
                        <div class="row col-md-12 mb-9">
                            <div class="col-md-12 mb-4">
                                <h2 style="color: gray;">Деталі замовлення заказу </h2>
                            </div>
                        </div>
                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="execution_date">Дата виконання замовлення</label>
                            </div>
                            <div class="col-md-3 mb-4">
                                <input type="date" name="order_details[${index}][execution_date_date]" class="form-control" value="">
                            </div>
                            <div class="col-md-3 mb-4">
                                <input type="time" name="order_details[${index}][execution_date_time]" class="form-control" value="">
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Тип послуг</label>
                            </div>
                            <div class="col-md-6 mb-4">

                                <select name="order_details[${index}][service_type]" class="form-control" required>
                                    <option value="" disabled selected> </option>
                                    <option value="Прибирання будівельного сміття" {{ request()->input('service_type') == 'Прибирання будівельного сміття' ? 'selected' : '' }}>Прибирання будівельного сміття</option>
                                    <option value="Перевезення великогабаритних об'єктів" {{ request()->input('service_type') == "Перевезення великогабаритних об'єктів" ? 'selected' : '' }}>Перевезення великогабаритних об'єктів</option>
                                    <option value="Розвантаження-завантаження" {{ request()->input('service_type') == 'Розвантаження-завантаження' ? 'selected' : '' }}>Розвантаження-завантаження</option>
                                </select>
                            </div>
                        </div>
                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Місто</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <select name="order_details[${index}][city]" class="form-control" required>
                                    <option value="" disabled selected> </option>
                                    <option value="" disabled {{ request()->input('city')  == null ? 'selected' : '' }}>Выберите город</option>
                                    <option value="Днепр" {{ request()->input('city')  == 'Днепр' ? 'selected' : '' }}>Днепр</option>
                                    <option value="Харкiв" {{ request()->input('city')  == 'Харкiв' ? 'selected' : '' }}>Харкiв</option>
                                    <option value="Львів" {{ request()->input('city')  == 'Львів' ? 'selected' : '' }}>Львів</option>
                                    <option value="Київ" {{ request()->input('city')  == 'Київ' ? 'selected' : '' }}>Київ</option>
                                </select>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Вулиця</label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <select name="order_details[${index}][street]" class="form-control" required>
                                <option value="" disabled selected> </option>
                                <option value="Вулиця 1" {{ request()->input('street') == 'Вулиця 1' ? 'selected' : '' }}>Вулиця 1</option>
                                <option value="Вулиця 2" {{ request()->input('street') == "Вулиця 2" ? 'selected' : '' }}>Вулиця 2</option>
                                <option value="Вулиця 3" {{ request()->input('street') == 'Вулиця 3' ? 'selected' : '' }}>Вулиця 3</option>
                                <option value="Вулиця 4" {{ request()->input('street') == 'Вулиця 4' ? 'selected' : '' }}>Вулиця 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Будинок</label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <select name="order_details[${index}][house]" class="form-control" required>
                                <option value="" disabled selected> </option>
                                <option value="34а" {{ request()->input('house') == '34а' ? 'selected' : '' }}>34а</option>
                                <option value="56б" {{ request()->input('house') == "56б" ? 'selected' : '' }}>56б</option>
                                <option value="23г" {{ request()->input('house') == '23г' ? 'selected' : '' }}>23г</option>
                                <option value="17" {{ request()->input('house') == '17' ? 'selected' : '' }}>17</option>
                            </select>
                        </div>
                    </div>



                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Кількість робітників</label>
                        </div>
                        <div class="col-md-6 mb-4">
                        <select name="order_details[${index}][number_of_workers]" class="form-control">
                            <option value="" disabled selected> </option>
                            <option value="1" {{ request()->input('number_of_workers') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ request()->input('number_of_workers') == "2" ? 'selected' : '' }}>2</option>
                            <option value="3" {{ request()->input('number_of_workers') == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ request()->input('number_of_workers') == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ request()->input('number_of_workers') == "5" ? 'selected' : '' }}>5</option>
                            <option value="6" {{ request()->input('number_of_workers') == '6' ? 'selected' : '' }}>6</option>
                            <option value="7" {{ request()->input('number_of_workers') == '7' ? 'selected' : '' }}>7</option>
                            <option value="8" {{ request()->input('number_of_workers') == '8' ? 'selected' : '' }}>8</option>
                            <option value="9" {{ request()->input('number_of_workers') == "9" ? 'selected' : '' }}>9</option>
                            <option value="10" {{ request()->input('number_of_workers') == '10' ? 'selected' : '' }}>10</option>
                            <option value="11" {{ request()->input('number_of_workers') == '11' ? 'selected' : '' }}>11</option>
                            <option value="12" {{ request()->input('number_of_workers') == '12' ? 'selected' : '' }}>12</option>
                        </select>
                        </div>
                    </div>



                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Транспорт</label>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <input type="checkbox" {{ request()->input('transport') ? 'checked' : '' }}>
                                    </span>
                                </div>
                                <select name="order_details[${index}][transport]" class="form-control">
                                    <option value="" disabled selected> </option>
                                    <option value="Легкова 1" {{ request()->input('transport') == 'Легкова 1' ? 'selected' : '' }}>Легкова 1</option>
                                    <option value="Легкова 2" {{ request()->input('transport') == 'Легкова 2' ? 'selected' : '' }}>Легкова 2</option>
                                    <option value="Грузова 1" {{ request()->input('transport') == 'Грузова 1' ? 'selected' : '' }}>Грузова 1</option>
                                    <option value="Грузова 2" {{ request()->input('transport') == 'Грузова 2' ? 'selected' : '' }}>Грузова 2</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="task_description">Примітка до замовлення</label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <textarea name="order_details[${index}][task_description]" class=" mb-3 form-control" rows="3" placeholder="">{{ request()->input('task_description')}}</textarea>
                                <input name="order_details[${index}][straps]" class="form-check-input ml-1" type="checkbox" value="1" {{ request()->input('straps') ? 'checked' : '' }}>
                                <label for="straps" style="font-weight: normal;" class="ml-4">Ремені</label>
                                <input name="order_details[${index}][tools]" class="form-check-input ml-1" type="checkbox" value="1" {{ request()->input('tools') ? 'checked' : '' }}>
                                <label for="tools" style="font-weight: normal;" class="ml-4">Інструменти</label>
                                <input name="order_details[${index}][respirators]" class="form-check-input ml-1" type="checkbox" value="1" {{ request()->input('respirators') ? 'checked' : '' }}>
                                <label for="respirators" style="font-weight: normal;" class="ml-4">Респіратори</label>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Орієнтовна тривалість замовлення</label>
                        </div>
                        <div class="col-md-2 mb-4">

                            <select name="order_details[${index}][order_hrs]" class="form-control">
                                <option value="" disabled selected> </option>
                                <option value="1" {{ request()->input('order_hrs') == '1.00' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ request()->input('order_hrs') == "2.00" ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request()->input('order_hrs') == '3.00' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ request()->input('order_hrs') == '4.00' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ request()->input('order_hrs') == '5.00' ? 'selected' : '' }}>5</option>
                                <option value="6" {{ request()->input('order_hrs') == '6.00' ? 'selected' : '' }}>6</option>
                                <option value="7" {{ request()->input('order_hrs') == '7.00' ? 'selected' : '' }}>7</option>
                                <option value="8" {{ request()->input('order_hrs') == '8.00' ? 'selected' : '' }}>8</option>
                                <option value="9" {{ request()->input('order_hrs') == '9.00' ? 'selected' : '' }}>9</option>
                                <option value="10" {{ request()->input('order_hrs') == '10.00' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ request()->input('order_hrs') == '11.00' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ request()->input('order_hrs') == '12.00' ? 'selected' : '' }}>12</option>
                            </select>
                        </div>
                    </div>
                    <hr class="w-100">

                    <div class="row col-md-12 mb-9">
                        <div class="col-md-12 mb-4">
                            <h2 style="color: gray;">Оплата</h2>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-2">
                            <label for="">Вартість замовлення</label>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="">Клієнту</label>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="">Робочим</label>
                        </div>
                    </div>
                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-2">
                            <label for=""> </label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" name="order_details[${index}][price_to_customer]" class="form-control" value="{{ request()->input('price_to_customer') }}">

                                </div>
                                <div class="col-4">
                                    <input type="text" name="order_details[${index}][price_to_workers]" class="form-control" value="{{ request()->input('price_to_workers') }}">
                                </div>
                                <div class="col-5">
                                    <select id="rate" name="rate" class="form-control">
                                        <option value="200/100">200/100</option>
                                        <option value="300/400">300/400</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Сума мінімального замовлення</label>
                        </div>
                        <div class="col-md-2 mb-4">
                            <input type="text" name="order_details[${index}][min_order_amount]" class="form-control" value="{{ request()->input('min_order_amount') }}" required>
                        </div>
                        <div class="col-md-2 mb-4">
                            <label for="">грн.</label>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="phone">Мінімальне замовлення</label>
                        </div>
                        <div class="col-md-2 mb-4">
                            <input type="text" name="order_details[${index}][min_order_hrs]" class="form-control" value="{{ request()->input('min_order_hrs') }}" required>
                        </div>
                        <div class="col-md-2 mb-4">
                            <label for="">годин</label>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Примітка до оплати</label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <textarea name="order_details[${index}][payment_note]" class=" mb-3 form-control" rows="3" placeholder="">{{ request()->input('payment_note') }}</textarea>
                        </div>
                    </div>



        `;

        formContainer.insertAdjacentHTML("beforeend", newForm);
    });
</script>









<script>
        document.addEventListener("DOMContentLoaded", function() {

    let index = 0;
    document.getElementById("add-client-date-button").addEventListener("click", function() {
        const formContainer = document.getElementById("client-details-forms");
        index++;

        const newForm = `
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 400px">Прізвище, ім'я, по батькові</th>
                                <th style="width: 200px">Посада</th>
                                <th style="width: 200px">Телефон</th>
                                <th style="width: 200px">Email</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <div class="row">
                                         <div class="col">

                                            <input type="input" name="client_contacts[${index}][full_name]" class="form-control" value="" required placeholder="Прізвище">
                                        </div>
                                        <div class="col">
                                            <input type="input" name="client_contacts[${index}][name]" class="form-control" value="" required placeholder="Ім'я">
                                        </div>
                                        <div class="col">
                                            <input type="input" name="client_contacts[${index}][last_name]" class="form-control" value="" required placeholder="По батькові">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="input" name="client_contacts[${index}][position]" class="form-control" value="" required>
                                </td>
                                <td>
                                    <input type="input" name="client_contacts[${index}][client_phone]" class="form-control" value="" required>
                                </td>
                                <td>
                                    <input type="input" name="client_contacts[${index}][email]" class="form-control" value="" required>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
        `;

        formContainer.insertAdjacentHTML("beforeend", newForm);
    });
});

</script>




<script>
document.addEventListener("DOMContentLoaded", function() {
    let index = 0;
    const formContainer = document.getElementById("contact-details-forms");
    const addButton = document.getElementById("add-contact-date-button");

    addButton.addEventListener("click", function() {
        index++;

        const newForm = `
        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 400px">Прізвище, ім'я, по батькові</th>
                                <th style="width: 200px">Посада</th>
                                <th style="width: 200px">Телефон</th>
                                <th style="width: 200px">Email</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <div class="row">
                                         <div class="col">

                                            <input type="input" name="add_client_contacts[${index}][full_name]" class="form-control" value="" required placeholder="Прізвище">
                                        </div>
                                        <div class="col">
                                            <input type="input" name="add_client_contacts[${index}][name]" class="form-control" value="" required placeholder="Ім'я">
                                        </div>
                                        <div class="col">
                                            <input type="input" name="add_client_contacts[${index}][last_name]" class="form-control" value="" required placeholder="По батькові">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="input" name="add_client_contacts[${index}][position]" class="form-control" value="" required>
                                </td>
                                <td>
                                    <input type="input" name="add_client_contacts[${index}][client_phone]" class="form-control" value="" required>
                                </td>
                                <td>
                                    <input type="input" name="add_client_contacts[${index}][email]" class="form-control" value="" required>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
        `;

        formContainer.insertAdjacentHTML("beforeend", newForm);
    });

    // Обработка события удаления формы
    formContainer.addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-client-contact")) {
            event.preventDefault();
            event.target.closest("tr").remove();
        }
    });
});
</script>










<script>
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
</script>

<script>
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
</script>

<script>
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
</script>

<script>
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
</script>

<script>
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
</script>



<script>
    $(document).ready(function() {
        var basicInfoTab = document.getElementById('basicInfoBtn');
        var documentsTab = document.getElementById('documentsBtn');
        var historyTab = document.getElementById('historyBtn');

        var basicInfoForm = document.getElementById('basicInfoForm');
        var documentsForm = document.getElementById('documentsForm');
        var historyForm = document.getElementById('historyForm');

        // Функция для сохранения состояния выбранной вкладки
        function saveSelectedTab(tabId) {
            localStorage.setItem('selectedTab', tabId);
        }

        // Функция для восстановления состояния выбранной вкладки
        function restoreSelectedTab() {
            var selectedTabId = localStorage.getItem('selectedTab');

            if (selectedTabId) {
                // Скрываем все формы
                basicInfoForm.style.display = 'none';
                documentsForm.style.display = 'none';
                historyForm.style.display = 'none';

                // Отображаем выбранную вкладку
                if (selectedTabId === 'basicInfoBtn') {
                    basicInfoForm.style.display = 'block';
                } else if (selectedTabId === 'documentsBtn') {
                    documentsForm.style.display = 'block';
                } else if (selectedTabId === 'historyBtn') {
                    historyForm.style.display = 'block';
                }
            }
        }

        basicInfoTab.addEventListener('click', function(e) {
            e.preventDefault();
            basicInfoForm.style.display = 'block';
            documentsForm.style.display = 'none';
            historyForm.style.display = 'none';
            saveSelectedTab('basicInfoBtn');
        });

        documentsTab.addEventListener('click', function(e) {
            e.preventDefault();
            basicInfoForm.style.display = 'none';
            documentsForm.style.display = 'block';
            historyForm.style.display = 'none';
            saveSelectedTab('documentsBtn');
        });

        historyTab.addEventListener('click', function(e) {
            e.preventDefault();
            basicInfoForm.style.display = 'none';
            documentsForm.style.display = 'none';
            historyForm.style.display = 'block';
            saveSelectedTab('historyBtn');
        });

        // Восстановление состояния выбранной вкладки при загрузке страницы
        restoreSelectedTab();
    });
</script>


<script>
    $(document).ready(function() {
        var documentsTab = document.getElementById('accountantDocumentsBtn');
        var historyTab = document.getElementById('accountantHistoryBtn');

        var documentsForm = document.getElementById('accountantDocumentsForm');
        var historyForm = document.getElementById('accountantHistoryForm');

        // Функция для сохранения состояния выбранной вкладки
        function saveSelectedTab(tabId) {
            localStorage.setItem('selectedTab', tabId);
        }

        // Функция для восстановления состояния выбранной вкладки
        function restoreSelectedTab() {
            var selectedTabId = localStorage.getItem('selectedTab');

            if (selectedTabId) {
                // Скрываем все формы
                documentsForm.style.display = 'none';
                historyForm.style.display = 'none';

                // Отображаем выбранную вкладку
                if (selectedTabId === 'accountantDocumentsBtn') {
                    documentsForm.style.display = 'block';
                } else if (selectedTabId === 'accountantHistoryBtn') {
                    historyForm.style.display = 'block';
                }
            }
        }



        documentsTab.addEventListener('click', function(e) {
            e.preventDefault();
            documentsForm.style.display = 'block';
            historyForm.style.display = 'none';
            saveSelectedTab('accountantDocumentsBtn');
        });

        historyTab.addEventListener('click', function(e) {
            e.preventDefault();

            documentsForm.style.display = 'none';
            historyForm.style.display = 'block';
            saveSelectedTab('accountantHistoryBtn');
        });

        // Восстановление состояния выбранной вкладки при загрузке страницы
        restoreSelectedTab();
    });
</script>







<script>
    document.addEventListener('DOMContentLoaded', function() {
        var basicInfoBtn2 = document.getElementById('basicInfoBtn2');
        var documentsBtn2 = document.getElementById('documentsBtn2');
        var historyBtn2 = document.getElementById('historyBtn2');

        var basicInfoForm2 = document.getElementById('basicInfoForm2');
        var documentsForm2 = document.getElementById('documentsForm2');
        var historyForm2 = document.getElementById('historyForm2');

        basicInfoBtn2.addEventListener('click', function(e) {
            e.preventDefault();
            basicInfoForm2.style.display = 'block';
            documentsForm2.style.display = 'none';
            historyForm2.style.display = 'none';
        });

        documentsBtn2.addEventListener('click', function(e) {
            e.preventDefault();
            basicInfoForm2.style.display = 'none';
            documentsForm2.style.display = 'block';
            historyForm2.style.display = 'none';
        });

        historyBtn2.addEventListener('click', function(e) {
            e.preventDefault();
            basicInfoForm2.style.display = 'none';
            documentsForm2.style.display = 'none';
            historyForm2.style.display = 'block';
        });
    });
</script>



<script>
        $(document).ready(function() {
        $('#basicInfoBtn2').click(function(e) {
            e.preventDefault();
            $('.form-content').removeClass('active');
            $('#basicInfoForm2').addClass('active');
            $('.btn').removeClass('active');
            $('#basicInfoLabel2').addClass('active');
        });

        $('#documentsBtn2').click(function(e) {
            e.preventDefault();
            $('.form-content').removeClass('active');
            $('#documentsForm2').addClass('active');
            $('.btn').removeClass('active');
            $('#documentsLabel2').addClass('active');
        });

        $('#historyBtn2').click(function(e) {
            e.preventDefault();
            $('.form-content2').removeClass('active');
            $('#historyForm2').addClass('active');
            $('.btn').removeClass('active');
            $('#historyLabel2').addClass('active');
        });
    });

</script>



















<script>
    function updateFileName(input, labelId) {
        var fileNameLabel = document.getElementById(labelId);
        fileNameLabel.textContent = input.files[0].name;
    }
</script>




<style>
    @media (max-width: 1424px) {
        /* Устанавливаем размер шрифта 12px при маленьком разрешении экрана */
        .small-font {
            font-size: 12px;
        }
    }
</style>
<script>
    document.getElementById('select-all-leads').addEventListener('change', function() {
        var checkboxes = document.getElementsByName('selected_leads[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });
</script>

<script>
    document.getElementById('select_all_emails').addEventListener('change', function() {
        var checkboxes = document.getElementsByName('selected_emails[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });
</script>


<script>
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
</script>

<script>
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
</script>
<script>
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
</script>

<script>
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
</script>

<script>
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
</script>


<script>
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
</script>

<script>
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
</script>


<script>
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

</script>




<script>
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
</script>



<script>
    function submitForm(orderDocumentId) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Рахунок сплачено");
                        // Reload the page without changing the hash
                        window.location.reload(false);
                    } else {
                        alert("Помилка під час виконання запиту");
                    }
                } else {
                    alert("Помилка під час виконання запиту");
                }
            }
        };


        if (Auth::user()->is_manager) {
            xhr.open("PUT", "{{ route('erp.manager.orders.toBankOperations', ['id' => '__id__']) }}".replace('__id__', orderDocumentId), true);

        }else if(Auth::user()->is_accountant){
            xhr.open("PUT", "{{ route('erp.accountant.orders.toBankOperations', ['id' => '__id__']) }}".replace('__id__', orderDocumentId), true);

        }




        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Prevent the default form submission
        event.preventDefault();

        xhr.send();
    }
</script>



<!--modal-->
<script>

// Функция для открытия модального окна

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
          window.location.href = tasksIndexUrl;

        })
        .catch(function(error) {
          console.error("Error:", error);
        });


    });


</script>


<script>
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
</script>


<!--modal-->
<script>
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
</script>


<script>
    $(document).ready(function () {
        // Handle the delete link click
        $('#confirmationModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var deleteUrl = button.data('delete-url'); // Get the delete URL from data attribute
            $('#deleteLink').attr('href', deleteUrl); // Set the href of the Delete button

            // Handle the Delete button click
            $('#deleteLink').on('click', function () {
                $('#confirmationModal').modal('hide'); // Close the modal
                // Redirect to the delete URL
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
  // Chart.js
  var ctx = document.getElementById('myChart').getContext('2d');

  // Создайте график
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн'],
      datasets: [{
        label: 'Продажи',
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      },
      {
        label: 'Прибыль',
        data: [8, 12, 5, 10, 6, 8],
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<script>
  // Chart.js
  var ctx = document.getElementById('myChart2').getContext('2d');

  // Create the chart
  var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: {!! isset($labels) ? json_encode($labels) : 'null' !!},
    datasets: [{
      label: 'Замовлення',
      data: {!! isset($data) ? json_encode($data) : 'null' !!},
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1
    },
    {

      label: 'Залишок компанії',
      data: {!! isset($balance) ? json_encode($balance) : 'null' !!},
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1
      }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>





<script>
    document.getElementById('toggleThemeBtn').addEventListener('click', function() {
    // Переключение темы
    document.body.classList.toggle('dark-mode');

    // Сохранение состояния темы в localStorage
    const isDarkModeEnabled = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkModeEnabled);
});
</script>

<script>
    // Проверка состояния темы при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkModeEnabled = localStorage.getItem('darkMode') === 'true';

        // Применение темной темы, если она сохранена
        if (isDarkModeEnabled) {
            document.body.classList.add('dark-mode');
        }
    });
</script>





<script>
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
</script>








<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="../../plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

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
  myDropzone.on("queuecomplete", function(progress) {
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
  // DropzoneJS Demo Code End
</script>

<!-- modal tasks -->


<!-- gen tasks -->

<script>
    $(document).ready(function() {
        // Функция для обновления почты
        function updateEmails() {
            $.ajax({
                url: '{{ route("erp.executive.emails.getMails") }}', // Используем ваш путь для метода getMails
                type: 'GET',
                success: function(response) {
                    // Обработка успешного обновления
                    console.log('Почта успешно обновлена');
                },
                error: function(error) {
                    // Обработка ошибки обновления
                    console.error('Ошибка при обновлении почты', error);
                }
            });
        }

        // Запускаем обновление каждые 5 минут
        setInterval(function() {
            updateEmails();
        }, 300000); // 300000 миллисекунд = 5 минут
    });
</script>




<!-- Bootstrap 4 -->
<!-- <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/appjs.js') }}"></script>

<!-- overlayScrollbars -->
<!-- <script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- AdminLTE App -->
<!-- <script src="/admin/dist/js/adminlte.min.js"></script> -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>



</body>
</html>

