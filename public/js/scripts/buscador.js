//import "./IndicadorElementoCourrousel";

class Buscador
{
    indiceCarrouseles;
    constructor()
    {
        this.indiceCarrouseles = [];
    }

    cargarCaourrouselesPublicaciones() {
        const pictures = document.querySelector("figure>picture");
        let pictureCount = 1;
        pictures.forEach(picture => {
            if (pictureCount === 1) {
                const pictureInfo = new IndicadorElementoCourrousel();
                pictureInfo.countElements = picture.getElementsByTagName("img").length;
                pictureInfo.selectedItem = 1;
                pictureInfo.index = pictureCount;
                picture.set
            }
        })
    }

    addAddToCartEvent() {
        let items = document.querySelectorAll("article > a");
        items.forEach((item) => {
            const originalId = item.id.split("-");
            if (originalId[0]==="addToCart") {
                const id = originalId[1];
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
        });

        let figures = document.querySelectorAll("figure");
        console.log(figures)
        figures.forEach((figure) => {
            let img = figure.querySelector("img");
            console.log(img)
            img.classList.remove("hidden");
        });
    }
}

document.addEventListener("DOMContentLoaded",()=>{
    let buscador = new Buscador();
    buscador.addAddToCartEvent();
});