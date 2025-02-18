document.addEventListener('DOMContentLoaded', function () {

    function removeAltertMessage() {
        const alertElement = document.querySelector('.alert.alert-danger');

        // Remove em 3 segundos
        if (alertElement) {
            setTimeout(() => {
                alertElement.remove();
            }, 3000);
        }
    }

    removeAltertMessage();

});
