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
                newOption.value = location.id;
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
                    newOption.value = location.id;
                    newOption.text = location.nombre;
                    locationSelect.appendChild(newOption);
                });
            });
        });

        let form = document.querySelector("section > section > form");
        console.log(form)
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            let values = new FormData(form);
            let provinceId = document.querySelector("#provincia");
            let locationId = document.querySelector("#ciudad");
            fetch(
                "add-address?cod-postal=" + values.get("cod-postal")
                + "&provincia=" + provinceId.value
                + "&ciudad=" + locationId.value
                + "&calle=" + values.get("calle")
                + "&numero=" + values.get("numero")
                + "&departamento=" + values.get("departamento")
                ,
                {
                    method: "POST"
                }
            ).then((response)  => {
                this.recargarListDirecciones();
            });
        });


    }

    recargarListDirecciones() {
        fetch(
            "address-list",
            {
                method: "GET"
            }
        ).then((response)  => {
            return response.json();
        }).then((data) => {
            console.log(data);
            let list = document.querySelector("#details-list > ul");
            list.innerHTML = "";
            let h4 = document.createElement("h4");
            h4.textContent = "Direcciones disponibles";
            list.appendChild(h4);
            data.forEach((address) => {
                let newLi = document.createElement("li");
                let newP = document.createElement("p");
                newP.textContent = address.calle + ", " + address.nombreProvincia + ", " + address.nombreCiudad;
                newLi.appendChild(newP);
                if (address.default !== "SI") {
                    let button = document.createElement("button");
                    button.addEventListener("click", () => {
                        fetch(
                            "/set-default-address?id_address=" + address.id,
                            {
                                method: "POST"
                            }
                        ).then((response)  => {
                            window.location.replace("/profile-address")
                            return false;
                        })
                    });

                    button.textContent = "Usar por defecto";
                    newLi.appendChild(button);
                }
                else {
                    newP.textContent += " (Predeterminado)";
                }

                list.appendChild(newLi);
            });
        });
    }
}

document.addEventListener("DOMContentLoaded",()=>{
    let perfilDirecciones = new PerfilDirecciones();
    perfilDirecciones.addPostEvents();
    perfilDirecciones.recargarListDirecciones();
});