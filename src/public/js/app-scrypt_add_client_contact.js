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
