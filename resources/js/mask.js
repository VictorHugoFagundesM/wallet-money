document.addEventListener('DOMContentLoaded', function () {

    function moneyMask() {

        const moneyInput = document.getElementById('money_mask');

        moneyInput?.addEventListener('input', function (e) {
            let value = e.target.value
                .replace(/\D/g, '')
                .padStart(3, '0');

            let money = Math.floor(value / 100);
            let cents = value % 100;
            e.target.value = money.toLocaleString('pt-BR') + ',' + cents.toString().padStart(2, '0');
        });

        // Inicia o campo com esse valor
        let event = new Event('input', {
            bubbles: true,
            cancelable: true,
        });

        moneyInput?.dispatchEvent(event);

    }

    function accountNumberMask() {
        document.getElementById('account_number_mask')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) {
                value = value.slice(0, 8) + '-' + value.slice(8, 11);
            }
            e.target.value = value;
        });
    }

    moneyMask();
    accountNumberMask();
});
