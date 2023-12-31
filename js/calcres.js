window.addEventListener("DOMContentLoaded", () => { 

    function calcuTotalPrice() {
        const productPrice = document.getElementById("productPrice").value;

        const quantityInput = document.getElementById('quantity');
        const quantity = parseInt(quantityInput.value) || 0;

        const totalPriceQuantity = productPrice * quantity;

        document.getElementById("totalprice").value = totalPriceQuantity;
        
    }

    function calculateChange() {
        const totalPrice = parseInt(document.getElementById("totalprice").value) || 0;
        const payment = parseInt(document.getElementById("payment").value) || 0;

        var calc = payment - totalPrice;

        document.getElementById("change").value = calc.toFixed(2);
    }

    document.getElementById("totalprice").addEventListener("input", calculateChange);
    document.getElementById("payment").addEventListener("input", calculateChange);
    document.getElementById("quantity").addEventListener("input", calcuTotalPrice);
});