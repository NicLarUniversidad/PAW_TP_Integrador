class Envios {
    addPostEvents() {
        let items = document.querySelectorAll("article > button");
        items.forEach((item) => {
            const originalId = item.id;
            const id = originalId.split("-");
            if (id[0]==="acciones") {
                let url = "";
                if (id[1]==="PENDIENTE_DE_ENVIO") {
                    //Post enviar paquete
                    url = "/shipments/send";
                }
                else if (id[1]==="ENVIADO") {
                    //Post recibir paquete
                    url = "/shipments/receive";
                }
                if (url !== "") {
                    item.addEventListener("click", () => {
                        fetch(
                            url + "?id_venta=" + id[2],
                            {
                                method: "POST"
                            }
                        ).then(data => {
                                window.location.replace("/shipments/all")
                                return false;
                            }
                        )
                    })
                }
            }
            else {
                //Si no comienza con eso, es un botón collapse
                item.addEventListener("click", () => {
                    item.classList.toggle("active");
                    let content = item.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
        });
    }
}



document.addEventListener("DOMContentLoaded",()=>{
    let envios = new Envios();
    envios.addPostEvents();
});