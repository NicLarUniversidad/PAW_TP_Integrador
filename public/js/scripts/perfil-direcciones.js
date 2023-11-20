class PerfilDirecciones {
    addPostEvents() {
        fetch(
            "/location?provincia_id=1",
            {
                method: "GET"
            }
        ).then(data => {
                return data.json();
            }
        ).then((locations) => {
            let locationSelect = document.querySelector("#ciudad");
            locationSelect.innerHTML = "";
            locations.forEach((location) => {
                let newOption = document.createElement("option");
                newOption.id = location.id;
                newOption.text = location.nombre;
                locationSelect.appendChild(newOption);
            });
        });
        let provinceSelect = document.querySelector("#provincia");
        provinceSelect.addEventListener("change", () => {
            const selectedProvinceId = provinceSelect.selectedIndex;
            fetch(
                "/location?provincia_id=" + selectedProvinceId,
                {
                    method: "GET"
                }
            ).then(data => {
                    return data.json();
                }
            ).then((locations) => {
                let locationSelect = document.querySelector("#ciudad");
                locationSelect.innerHTML = "";
                locations.forEach((location) => {
                    let newOption = document.createElement("option");
                    newOption.id = location.id;
                    newOption.text = location.nombre;
                    locationSelect.appendChild(newOption);
                });
            });
        });
    }
}

document.addEventListener("DOMContentLoaded",()=>{
    let perfilDirecciones = new PerfilDirecciones();
    perfilDirecciones.addPostEvents();
});