class MisCompras {

    addButtonRedirect() {
        let items = document.querySelectorAll("article > button");
        items.forEach((item) => {
            const originalId = item.id;
            const id = originalId.split("-")[1];
            item.addEventListener("click", () => {
                window.location.replace("/detalle-compra?id_compra=" + id)
                return false;
            });
        });
    }

}

document.addEventListener("DOMContentLoaded",()=>{
    let misCompras = new MisCompras();
    misCompras.addButtonRedirect();
});