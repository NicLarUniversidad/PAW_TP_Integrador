import "./IndicadorElementoCourrousel";

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
}