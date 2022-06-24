(function ($) {

    "use strict";

    $(document).ready(function () {
        $('#preloader').fadeOut();
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
        $('form.form-horizontal').on('submit', function (event) {
            $(':submit', event.target).prop('disabled', true).addClass('btn-loading');
        });
        $('.password-show-toggle input').on('change input', function (event) {
            event.preventDefault();
            let icon = $(event.target).next('a').find('i');
            icon.attr('title', icon.data('show-text')).attr('class', icon.data('show-class')).show();
            icon.tooltip('dispose');
            icon.tooltip();
        });
        $('.password-show-toggle a.toggle-btn').on('click', function (event) {
            event.preventDefault();
            let id = $(event.target).data('input-id') || 'password';
            let input = $('.password-show-toggle input#'+id);
            let icon = $('.password-show-toggle input#'+id+' + a > i');
            if (input.attr('type') === 'text') {
                input.attr('type', 'password').focus();
                icon.attr('title', icon.data('show-text')).attr('class', icon.data('show-class'));
            } else if (input.attr('type') === 'password') {
                input.attr('type', 'text').focus();
                icon.attr('title', icon.data('hide-text')).attr('class', icon.data('hide-class'));
            }
            icon.tooltip('dispose');
            icon.tooltip('toggle');
        });
        $('.is-invalid').on('blur', function () {
            $(this).removeClass('is-invalid');
        });
        $('.js-redirect-onchange').on('change', function() {
            window.location.replace("/locale/" + $(this).val());
        });

        window.i18n.locale = app.settings.locale;
    });

}(jQuery));

function updatePhotoPreview() {
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    const currentPhoto = document.getElementById('current-photo');
    const photo = photoInput.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.style.backgroundImage = 'url(' + e.target.result + ')';
        photoPreview.style.display = 'block';
        currentPhoto.style.display = 'none';
    };

    reader.readAsDataURL(photo);
}