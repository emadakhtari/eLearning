$(document).ready(function () {
    $('#loadingPage').fadeIn();
    $.get("Ajax_GetList",
        {
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
    $.get("Ajax_GetList",
        {
            _token: $('#nekot').val(),
            search: $('#search').val(),
            province: $('#province').val(),
            city: $('#city').val(),
        },
        function (data, status) {
            $('#loadingPage').fadeOut();
            $('.result').html('').html(data);
        });
}


$("#province").change(function () {
    province()
});

function province() {
    $('#loadingPage').fadeIn();
    $.get("Ajax_GetList",
        {
            _token: $('#nekot').val(),
            search: $('#search').val(),
            province: $('#province').val(),
            city: $('#city').val(),
        },
        function (data, status) {
            $('#loadingPage').fadeOut();
            $('.result').html('').html(data);

        });
}

$("#city").change(function () {
    city()
});

function city() {
    $('#loadingPage').fadeIn();
    $.get("Ajax_GetList",
        {
            _token: $('#nekot').val(),
            search: $('#search').val(),
            province: $('#province').val(),
            city: $('#city').val(),
        },
        function (data, status) {
            $('#loadingPage').fadeOut();
            $('.result').html('').html(data);

        });
}
