$(function () {

    if (typeof toastr === 'undefined') {
        return;
    }

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3500
    };

    if (window.flashMessage.success) {
        toastr.success(window.flashMessage.success);
    }

    if (window.flashMessage.error) {
        toastr.error(window.flashMessage.error);
    }

    if (window.flashMessage.warning) {
        toastr.warning(window.flashMessage.warning);
    }

    if (window.flashMessage.info) {
        toastr.info(window.flashMessage.info);
    }

});
