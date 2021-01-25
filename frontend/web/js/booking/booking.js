$(function () {

    // *

    $(".navigate-container button[data-url]").click(function () {
        window.location.href = $(this).data("url");
    });

    // *


    // step 1 begin

    $("#postnummer-form input").on("input", function () {
        $("#main-next").attr("disabled", !(Number.isInteger(+$(this).val()) && $(this).val().length === 4))
    });

    $("#main-next").click(function () {
        $("#postnummer-form").submit();
    });

    $("#postnummer-form").on("keyup keypress", function (e) {
        let keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    // step 1 end


    // step 2 begin

    $('#booking-offices-modal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let title = button.data('title');
        if (title) {
            $(this).find('.modal-title').html(title);
        }

        let offices = button.data('offices');

        if (offices.length) {
            let body = $(this)
                .find('.modal-body')
                .empty();

            let content = '';

            offices.forEach(function (office) {
                content += `<h3><a class="d-block" href="${office.url}">${office.short_name}</a></h3>`
            });

            body.append(content);
        }
    });

    // step 2 end


    // step 3 begin

    $("#tjenester-next").click(function () {
        $("#tjenester-form").submit();
    });

    $("#tjenester-next").attr("disabled", !($("#tjenester-form").find("input[type=checkbox]:checked").length > 0));

    $("#tjenester-form input[type=checkbox]").click(function () {
        $("#tjenester-next").attr("disabled", !($("#tjenester-form").find("input[type=checkbox]:checked").length > 0));
    });

    // step 3 end

    // step 5 begin

    $("#meglerbooking-form").submit(function () {
        $.ajax({
            url: window.location.pathname,
            type: 'GET',
            data: {
                'formName': $(this).find("input#forms-name").val()
            }
        });
    })

    // step 5 end

});