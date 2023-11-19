class DetalleProducto {
    addPostEvents() {
        let pic = document.querySelector(".hidden");
        pic.classList.remove("hidden");
        pic.classList.add("not-hidden");
        let previewPics = document.querySelectorAll("section > section > picture > picture");
        previewPics.forEach((previewPic) => {
            let id = previewPic.id.split("-")[1];
            previewPic.addEventListener("click", () => {
                let unhiddenPic = document.querySelector(".not-hidden");
                unhiddenPic.classList.add("hidden");
                unhiddenPic.classList.remove("not-hidden");
                let image = document.querySelector("#img-" + id);
                image.classList.remove("hidden");
                image.classList.add("not-hidden");
            });
        });
        let item = document.querySelector(".agregar");
        const id = item.id.split("-")[1];
        item.addEventListener("click", () => {
            fetch(
                "/addItem?publicationId=" + id,
                {
                    method: "POST"
                }
            ).then(() => {
                    window.location.replace("/carrito")
                    return false;
                }
            )
        })
    }
}

document.addEventListener("DOMContentLoaded",()=>{
    let detalleProducto = new DetalleProducto();
    detalleProducto.addPostEvents();
});