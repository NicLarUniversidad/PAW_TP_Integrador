class BotonMercadoPago {
    constructor() {
    }
    init(mercadopago) {
        this.mercadopago = mercadopago;
        const button = document.getElementById("checkout-btn");
        // Handle call to backend and generate preference.
        button.addEventListener("click", function () {

            button.setAttribute("disabled", "true");

            const orderData = {
                // quantity: document.getElementById("quantity").value,
                // description: document.getElementById("product-description").innerHTML,
                // price: document.getElementById("unit-price").innerHTML
            };

            fetch("http://localhost:12000/create_preference", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(orderData),
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (preference) {
                    this.createCheckoutButton(preference.id);

                    //$(".shopping-cart").fadeOut(500);
                    setTimeout(() => {
                        //$(".container_payment").show(500).fadeIn();
                    }, 500);
                })
                .catch(function () {
                    alert("Unexpected error");
                    button.setAttribute("disabled", "false");
                });
        });

        // document.getElementById("quantity").addEventListener("change", updatePrice);
        // this.updatePrice();
        //
        // // Go back
        // document.getElementById("go-back").addEventListener("click", function () {
        //     //$(".container_payment").fadeOut(500);
        //     setTimeout(() => {
        //         //$(".shopping-cart").show(500).fadeIn();
        //     }, 500);
        //     button.setAttribute("disabled", "false");
        // });
    }

    createCheckoutButton(preferenceId) {
        // Initialize the checkout
        const bricksBuilder = mercadopago.bricks();

        const renderComponent = async (bricksBuilder) => {
            if (window.checkoutButton) window.checkoutButton.unmount();
            await bricksBuilder.create(
                'wallet',
                'button-checkout', // class/id where the payment button will be displayed
                {
                    initialization: {
                        preferenceId: preferenceId
                    },
                    callbacks: {
                        onError: (error) => console.error(error),
                        onReady: () => {}
                    }
                }
            );
        };
        window.checkoutButton =  renderComponent(bricksBuilder);
    }

    // Handle price update
    updatePrice() {
        // let quantity = document.getElementById("quantity").value;
        // let unitPrice = document.getElementById("unit-price").innerHTML;
        // let amount = parseInt(unitPrice) * parseInt(quantity);

        // document.getElementById("cart-total").innerHTML = "$ " + amount;
        // document.getElementById("summary-price").innerHTML = "$ " + unitPrice;
        // document.getElementById("summary-quantity").innerHTML = quantity;
        // document.getElementById("summary-total").innerHTML = "$ " + amount;
    }
}


let button = new BotonMercadoPago();