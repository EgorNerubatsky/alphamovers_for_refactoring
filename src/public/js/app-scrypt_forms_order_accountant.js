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