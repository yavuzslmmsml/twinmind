let cropper;

document.getElementById('thumbnailInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
        const preview = document.getElementById('thumbnailPreview');
        preview.src = event.target.result;
        preview.classList.remove('d-none');
        document.getElementById('cropButton').classList.remove('d-none');

        if (cropper) cropper.destroy();
        cropper = new Cropper(preview, {
            aspectRatio: 16 / 9,
            viewMode: 1,
        });
    };
    reader.readAsDataURL(file);
});

document.getElementById('cropButton').addEventListener('click', function () {
    if (!cropper) return;

    cropper.getCroppedCanvas({
        width: 800,
        height: 400
    }).toBlob(blob => {
        const reader = new FileReader();
        reader.onloadend = function () {
            document.getElementById('thumbnailBase64').value = reader.result;
        };
        reader.readAsDataURL(blob);
    });
});