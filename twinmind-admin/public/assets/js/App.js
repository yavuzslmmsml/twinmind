App = {

    DateFormat: function (format = 'Y-m-d', datetime = 'now') {
        let date;

        if (datetime === 'now') {
            date = new Date();
        } else if (typeof datetime === 'string' && datetime.includes('/')) {

            const [day, month, year] = datetime.split('/');
            date = new Date(year, month - 1, day);
        } else {
            date = new Date(datetime);
        }

        if (!date || isNaN(date)) {
            return '-';
        }

        const pad = (num) => String(num).padStart(2, '0');

        const formats = {
            'Y': date.getFullYear(),
            'm': pad(date.getMonth() + 1),
            'd': pad(date.getDate()),
            'H': pad(date.getHours()),
            'i': pad(date.getMinutes()),
            's': pad(date.getSeconds())
        };

        let formatted = format;
        for (const [key, value] of Object.entries(formats)) {
            formatted = formatted.replace(key, value);
        }

        return formatted;
    },

    RouteBack: function () {
        window.history.back();
    },

    BlockUI: function () {
        // Eğer zaten bir loader varsa, tekrar eklememek için önce temizleyelim
        if (document.getElementById('custom-block-ui')) {
            return;
        }

        // Div oluştur
        var blockDiv = document.createElement('div');
        blockDiv.id = 'custom-block-ui';
        blockDiv.style.position = 'fixed';
        blockDiv.style.top = '0';
        blockDiv.style.left = '0';
        blockDiv.style.width = '100%';
        blockDiv.style.height = '100%';
        blockDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        blockDiv.style.zIndex = '9999';
        blockDiv.style.display = 'flex';
        blockDiv.style.alignItems = 'center';
        blockDiv.style.justifyContent = 'center';

        blockDiv.innerHTML = `
            <div class="custom-loading-message" style="
                padding: 15px;
                background: transparent;
                border-radius: 10px;
                color: #fff;
                font-size: 18px;
                text-align: center;
            ">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i><br>
                Lütfen bekleyiniz...
            </div>
        `;
        document.body.appendChild(blockDiv);
    },

    UnBlockUI: function () {
        var blockDiv = document.getElementById('custom-block-ui');
        if (blockDiv) {
            blockDiv.remove();
        }
    },

    SwalError: function (html) {
        Swal.fire({
            title: 'Hata!',
            html: html,
            icon: 'error',
            confirmButtonText: 'Tamam',
            confirmButtonColor: '#dc3545',
        });
    },

    SwalSuccess: function (text) {
        Swal.fire({
            title: 'Başarılı!',
            text: text,
            icon: 'success',
            confirmButtonText: 'Tamam',
        });
    },

    SwalInfo: function (text) {
        Swal.fire({
            title: 'Bilgi!',
            text: text,
            icon: 'info',
            timer: 20000,
            confirmButtonText: 'Tamam',
            confirmButtonColor: '#17a2b8',
        });
    },

    SwalWarning: function (text) {
        Swal.fire({
            title: 'Uyarı!',
            text: text,
            icon: 'warning',
            timer: 20000,
            confirmButtonText: 'Tamam',
            confirmButtonColor: '#ffc107',
        });
    },

    FormSubmit: function (url, data, formID, redirect) {

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                App.BlockUI();
            },
            success: (e) => {
                App.UnBlockUI();
                console.log("FormSubmit: ", e);

                $(`${formID} .error-message`).remove();
                $(`${formID} input`).removeClass('border-danger');

                if (!e.status) {
                    if (e.errors) {
                        $.each(e.errors, (field, messages) => {
                            var input = $(`${formID} [name="${field}"]`);
                            input.addClass('border-danger');

                            $.each(messages, (key, message) => {
                                var errorMessage = `<div class="error-message text-danger small mt-1">${message}</div>`;
                                input.after(errorMessage);
                            });
                        });
                    }

                    if (e.message) {
                        Swal.fire({
                            title: 'Error',
                            text: e.message,
                            icon: 'error',
                        });
                    }
                } else {
                    if (formID) {
                        $(formID)[0].reset();
                    }
                    //Admin.SwalSuccess(e.message);
                    Swal.fire({
                        title: 'Başarılı',
                        text: e.message,
                        icon: 'success',
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    }).then(() => {
                        if (e.redirect) {
                            window.location.href = e.redirect;
                        } else if (redirect) {
                            if (redirect == window.location.pathname || redirect == window.location.pathname + window.location.hash) {
                                window.location.reload();
                            }
                            window.location.href = redirect;
                        } else {
                            window.location.reload();
                        }
                    });
                }
            }
        });
    },

    SubmitSignupForm: function () {
        var formData = new FormData(document.getElementById('kt_sign_up_form'));

        App.FormSubmit('/auth/signup', formData, '#kt_sign_up_form');
    },

    SubmitSigninForm: function () {
        var formData = new FormData(document.getElementById('kt_sign_in_form'));

        App.FormSubmit('/auth/signin', formData, '#kt_sign_in_form');
    }



}