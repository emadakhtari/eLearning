$(document).ready(function () {
    $('#loadingPage').fadeIn();
    $.get("Ajax_GetUserCategoryList",
        {
            pageNumber: 1,
            _token: $('#nekot').val(),
        },
        function (data, status) {
            $('#loadingPage').fadeOut();
            $('.result').html('').html(data);
        });
});

$('#search').keyup(function () {
    search();
});

function search() {
    $('#loadingPage').fadeIn();
    $.get("Ajax_GetUserCategoryList",
        {
            _token: $('#nekot').val(),
            search: $('#search').val(),
        },
        function (data, status) {
            $('#loadingPage').fadeOut();
            $('.result').html('').html(data);
        });
}

$("#user_category").on('change', function (e) {
    user_category();
});

function user_category() {
    $('#loadingPage').fadeIn();
    $.get("Ajax_GetUserCategoryList",
        {
            _token: $('#nekot').val(),
            search: $('#search').val(),
        },
        function (data, status) {
            $('#loadingPage').fadeOut();
            $('.result').html('').html(data);
        });
}

function paginating(pageNumber) {
    $('#loadingPage').fadeIn();
    $.get("Ajax_GetUserCategoryList",
        {
            _token: $('#nekot').val(),
            pageNumber: pageNumber,
            search: $('#search').val(),
        },
        function (data, status) {
            $('#loadingPage').fadeOut();
            $('.result').html('').html(data);
        });
}
