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
        const pageSize = document.querySelector("#select-page-size").value;
        const querySize = document.querySelector("#query-size").textContent;
        const firstSection = document.querySelector("main > section");
        let buttonSection = document.createElement("section");
        buttonSection.classList.add("button-section");

        let pageNumber = Math.floor(querySize / pageSize);
        if ((querySize % pageSize) > 0) {
            pageNumber++;
        }
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        // Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
        let category = params.sub_categoria ?? ""; // "some_value"
        let categorySubQuery = "";
        if (category !== "") {
            categorySubQuery = "&sub_categoria=" + category;
        }

        const actualUrl = window.location.href;
        const url = new URL(actualUrl);
        const query = url.searchParams.get("busqueda") ?? "";
        const selectSize = document.querySelector("#select-page-size");
        const orderSelect = document.querySelector("#order-select");
        for(let i = 0; i < pageNumber; i++) {
            let newButton = document.createElement("button");
            newButton.textContent = (i + 1);
            newButton.addEventListener("click", () => {
                window.location.search = "?buscador=" + query + "&page-size=" + pageSize + "&skip=" + i + "&order="  + orderSelect.value + categorySubQuery;
                return false;
            });
            buttonSection.appendChild(newButton);
        }

        firstSection.appendChild(buttonSection);

        selectSize.addEventListener("change", () => {
            const selectedValue = selectSize.value;
            window.location.search = "?buscador=" + query + "&page-size=" + selectedValue + "&skip=0&order="  + orderSelect.value + categorySubQuery;
        });

        orderSelect.addEventListener("change", () => {
            const selectedValue = orderSelect.value;
            window.location.search = "?buscador=" + query + "&page-size=" + selectedValue + "&skip=0&order=" + selectedValue + categorySubQuery;
        });
    }
}


    /*----------------------------------Ordenar por precio---------------------------- */
    /*
    function sortProductsPrice(){
        let sort = document.querySelector("#select-order").value;
        let items = document.querySelectorAll("article");
        let publicacionesNumber = Math.countElements(items);
        if (id[1]==="1") {
            for(let i = 0; i < publicacionesNumber; i++) {
                let newButton = document.createElement("button");
                newButton.textContent = (i + 1);
                newButton.addEventListener("click", () => {
                    window.location.search = "?buscador=" + query + "&page-size=" + pageSize + "&skip=" + i;
                    return false;
                });
            

        firstSection.appendChild(buttonSection);

        const selectOrder = document.querySelector("#select-page-size");
        selectSOrder.addEventListener("change", () => {
            const selectedValue = selectOrder.value;
            window.location.search = "?buscador=" + query + "&sort-by=" + selectedValue;
        });
    }
        }
    }*/

document.addEventListener("DOMContentLoaded",()=>{
    let buscador = new Buscador();
    buscador.addAddToCartEvent();
    buscador.AddPageEvents();
});