
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('company');
    const feedback = document.getElementById('company-error');

    input.addEventListener('blur', function () {
        const companyName = input.value;
        fetch('/check-company-exists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ company: companyName })
        })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    feedback.innerText = 'Компанія з такою назвою вже існує.';
                    feedback.style.display = 'block';
                } else {
                    feedback.style.display = 'none';
                }
            })
            .catch(error => console.error('Помилка:', error));
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('client_phone');
    const feedback = document.getElementById('phone-error');

    input.addEventListener('blur', function () {
        const clientPhone = input.value;
        fetch('/check-client-exists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ client_phone: clientPhone })
        })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    feedback.innerText = 'Кліент з таким номером вже існує.';
                    feedback.style.display = 'block';
                } else {
                    feedback.style.display = 'none';
                }
            })
            .catch(error => console.error('Помилка:', error));
    });
});
