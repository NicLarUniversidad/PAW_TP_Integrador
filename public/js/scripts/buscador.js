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
            let img = figure.querySelector("picture");
            console.log(img)
            img.classList.remove("hidden");
        });
    }

    AddPageEvents() {
        const pageSize = document.querySelector("#page-size").textContent;
        const querySize = document.querySelector("#query-size").textContent;
        const firstSection = document.querySelector("main > section");
        let buttonSection = document.createElement("section");
        buttonSection.classList.add("button-section");

        let pageNumber = Math.floor(querySize / pageSize);
        if ((querySize % pageSize) > 0) {
            pageNumber++;
        }
        const actualUrl = window.location.href;
        const url = new URL(actualUrl);
        const query = url.searchParams.get("busqueda") ?? "";
        for(let i = 0; i < pageNumber; i++) {
            let newButton = document.createElement("button");
            newButton.textContent = (i + 1);
            newButton.addEventListener("click", () => {
                window.location.search = "?buscador=" + query + "&page-size=" + pageSize + "&skip=" + i;
                return false;
            });
            buttonSection.appendChild(newButton);
        }

        firstSection.appendChild(buttonSection);

        const selectSize = document.querySelector("#select-page-size");
        selectSize.addEventListener("change", () => {
            const selectedValue = selectSize.value;
            window.location.search = "?buscador=" + query + "&page-size=" + selectedValue + "&skip=0";
        });
    }
}

document.addEventListener("DOMContentLoaded",()=>{
    let buscador = new Buscador();
    buscador.addAddToCartEvent();
    buscador.AddPageEvents();
});