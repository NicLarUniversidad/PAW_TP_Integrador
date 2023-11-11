class Envios {
    addPostEvents() {
        let items = document.querySelectorAll("article > button");
        items.forEach((item) => {
            const originalId = item.id;
            const id = originalId.split("-");
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
                            //window.location.replace("/shipments/all")
                            return false;
                        }
                    )
                })
            }
        });
    }
}



document.addEventListener("DOMContentLoaded",()=>{
    let envios = new Envios();
    envios.addPostEvents();
});