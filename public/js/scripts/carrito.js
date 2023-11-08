class Carrito {
    constructor(){

    }

    addDeleteCartItemEvent() {
        let items = document.querySelectorAll("article > button");
        items.forEach((item) => {
            const originalId = item.id;
            const id = originalId.split("-")[1];
            item.addEventListener("click", () => {
                function addItem(id) {
                    fetch(
                        "/addItem?publicationId=" + id,
                        {
                            method: "POST"
                        }
                    ).then(data => {
                            window.location.replace("/carrito")
                            return false;
                        }
                    )
                }
            })
        });
    }
    addMpButton() {
        // Add SDK credentials
        // REPLACE WITH YOUR PUBLIC KEY AVAILABLE IN: https://developers.mercadopago.com/panel
        const mercadopago = new MercadoPago("TEST-26dbdae3-8029-4cee-9ceb-70fe8181cc95", {
            locale: locale // The most common are: 'pt-BR', 'es-AR' and 'en-US'
        });
        button.init(mercadopago);

        fetch("/create_preference", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            }
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (preference) {
                createCheckoutButton(preference.id);
            });
    }

    createCheckoutButton(preferenceId) {

        mercadopago.bricks().create("wallet", "checkout-btn", {
            initialization: {
                preferenceId: preferenceId,
                redirectMode: "modal"
            },
            callbacks: {
                onError: (error) => console.error(error),
                onReady: () => {}
            }
        });
    }

    funcionEliminar() {
        var x = document.getElementById("productos");
        x.remove(x.selectedIndex);
    }

}

document.addEventListener("DOMContentLoaded",()=>{
    let carrito = new Carrito();
    carrito.addDeleteCartItemEvent();
    //carrito.addMpButton();
});