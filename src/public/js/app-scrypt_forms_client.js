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