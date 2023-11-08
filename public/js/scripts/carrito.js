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