

$(document).ready(function () {
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

    basicInfoTab.addEventListener('click', function (e) {
        e.preventDefault();
        basicInfoForm.style.display = 'block';
        documentsForm.style.display = 'none';
        historyForm.style.display = 'none';
        saveSelectedTab('basicInfoBtn');
    });

    documentsTab.addEventListener('click', function (e) {
        e.preventDefault();
        basicInfoForm.style.display = 'none';
        documentsForm.style.display = 'block';
        historyForm.style.display = 'none';
        saveSelectedTab('documentsBtn');
    });

    historyTab.addEventListener('click', function (e) {
        e.preventDefault();
        basicInfoForm.style.display = 'none';
        documentsForm.style.display = 'none';
        historyForm.style.display = 'block';
        saveSelectedTab('historyBtn');
    });

    // Восстановление состояния выбранной вкладки при загрузке страницы
    restoreSelectedTab();
});
