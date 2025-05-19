DeleteUser = {
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
            confirmButtonText: 'Ok',
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

    Delete: function (userId) {

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Dismiss'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '/users/',
                    type: 'POST',
                    data: { userId: userId },
                    dataType: 'json',
                    beforeSend: function () {
                        DeleteUser.BlockUI();
                    },
                    success: function (res) {
                        DeleteUser.UnBlockUI();

                        if (res.status == true) {
                            DeleteUser.SwalSuccess(res.message);
                            // Silinen kullanıcıyı tabloda DOM'dan kaldırmak istersen:
                            $(`[data-user-id="${userId}"]`).closest('tr').remove();

                        } else {
                            DeleteUser.SwalError(res.errors);
                        }
                    }
                });

            }
        });
    }
};