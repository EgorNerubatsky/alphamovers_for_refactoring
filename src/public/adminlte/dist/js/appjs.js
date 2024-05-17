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
                                <option value="34а" {{ request()->input('house') == '34а' ? 'selected' : '' }}>34а</option>
                                <option value="56б" {{ request()->input('house') == "56б" ? 'selected' : '' }}>56б</option>
                                <option value="23г" {{ request()->input('house') == '23г' ? 'selected' : '' }}>23г</option>
                                <option value="17" {{ request()->input('house') == '17' ? 'selected' : '' }}>17</option>
                            </select>
                        </div>   
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Макс. кількість робітників</label>
                        </div>   
                        <div class="col-md-6 mb-4">

                            <select name="order_details[${index}][number_of_workers]" class="form-control">
                                <option value="1" {{ request()->input('number_of_workers') == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ request()->input('number_of_workers') == "2" ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request()->input('number_of_workers') == '3' ? 'selected' : '' }}>3</option>
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
                            <label for="">Кількість робітників | транспорт</label>
                        </div>   
                        <div class="col-md-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <input type="checkbox" {{ request()->input('number_of_workers') ? 'checked' : '' }}>
                                    </span>
                                </div>
                                <select name="order_details[${index}][number_of_worker]" class="form-control">
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

                        <div class="col-md-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <input type="checkbox" {{ request()->input('transport') ? 'checked' : '' }}>
                                    </span>
                                </div>
                                <select name="order_details[${index}][transport]" class="form-control">
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
                                <input id="straps" name="straps" class="form-check-input ml-1" type="checkbox" value="1" {{ request()->input('straps') ? 'checked' : '' }}>
                                <label for="straps" style="font-weight: normal;" class="ml-4">Ремені</label>
                                <input id="tools" name="tools" class="form-check-input ml-1" type="checkbox" value="1" {{ request()->input('tools') ? 'checked' : '' }}>
                                <label for="tools" style="font-weight: normal;" class="ml-4">Інструменти</label>
                                <input id="respirators" name="respirators" class="form-check-input ml-1" type="checkbox" value="1" {{ request()->input('respirators') ? 'checked' : '' }}>
                                <label for="respirators" style="font-weight: normal;" class="ml-4">Респіратори</label>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Орієнтовна тривалість замовлення</label>
                        </div>   
                        <div class="col-md-2 mb-4">

                            <select name="order_details[${index}][min_order_hrs]" class="form-control">
                                <option value="1" {{ request()->input('min_order_hrs') == '1.00' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ request()->input('min_order_hrs') == "2.00" ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request()->input('min_order_hrs') == '3.00' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ request()->input('min_order_hrs') == '4.00' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ request()->input('min_order_hrs') == '5.00' ? 'selected' : '' }}>5</option>
                                <option value="6" {{ request()->input('min_order_hrs') == '6.00' ? 'selected' : '' }}>6</option>
                                <option value="7" {{ request()->input('min_order_hrs') == '7.00' ? 'selected' : '' }}>7</option>
                                <option value="8" {{ request()->input('min_order_hrs') == '8.00' ? 'selected' : '' }}>8</option>
                                <option value="9" {{ request()->input('min_order_hrs') == '9.00' ? 'selected' : '' }}>9</option>
                                <option value="10" {{ request()->input('min_order_hrs') == '10.00' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ request()->input('min_order_hrs') == '11.00' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ request()->input('min_order_hrs') == '12.00' ? 'selected' : '' }}>12</option>
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

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="logist">Призначити логіста</label>
                        </div>   
                        <div class="col-md-6 mb-4">
                            <select name="order_details[${index}][logist]" class="form-control">
                                <option value="Григорiй Мемчик" {{ request()->input('logist') == 'Григорiй Мемчик' ? 'selected' : '' }}>Григорiй Мемчик</option>
                                <option value="Жадан Квиря" {{ request()->input('logist') == "Жадан Квиря" ? 'selected' : '' }}>Жадан Квиря</option>
                                <option value="Тарас Бульба" {{ request()->input('logist') == 'Тарас Бульба' ? 'selected' : '' }}>Тарас Бульба</option>

                            </select>
                        </div>   
                    </div>
        
        `;

        formContainer.insertAdjacentHTML("beforeend", newForm);
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
    function toggleSidebar() {
        var sidebarWrapper = document.getElementById('sidebar-wrapper');
        var contentWrapper = document.getElementById('content-wrapper');
        if (sidebarWrapper.style.display === 'none') {
            sidebarWrapper.style.display = 'block';
            contentWrapper.style.marginLeft = '200px';
        } else {
            sidebarWrapper.style.display = 'none';
            contentWrapper.style.marginLeft = '0';
        }
    }
