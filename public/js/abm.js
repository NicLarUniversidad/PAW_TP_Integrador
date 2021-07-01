class Amb
{
    constructor()
    {
    }
    cargarModal() {
        const anchors = document.querySelectorAll("table a");
        const form = document.querySelector("form");
        const section = document.querySelector("table");
        form.classList.add("hidden_modal")
        const closeButton = document.createElement("button")
        const backModal = document.createElement("div")
        closeButton.classList.add("close_modal")
        backModal.classList.add("hidden_modal")
        closeButton.addEventListener("click", () => {
            form.classList.remove("modal")
            form.classList.add("hidden_modal")
            backModal.classList.remove("back_modal")
            backModal.classList.add("hidden_modal")
        })
        let registerButton = document. createElement("button");
        registerButton.textContent = "Agregar"
        registerButton.addEventListener("click", () => {
            form.classList.remove("hidden_modal")
            form.classList.add("modal")
            backModal.classList.remove("hidden_modal")
            backModal.classList.add("back_modal")
        })
        anchors.forEach((anchor, index) => {
            const href = anchor.href;
            anchor.addEventListener("click", (e) => {
                e.preventDefault()
                if (confirm("¿Desea borrar la entrada?")) {
                    fetch(href, {
                        method:"DELETE"
                    })
                        .then((data) => {

                        })
                        .catch(() => {
                            alert("No se pudo borrar el registro")
                        })
                }
            })
        })
        section.appendChild(registerButton)
        section.appendChild(backModal)
        form.appendChild(closeButton)
    }
    agregarBotonAgregar(url) {
        const anchor = document.querySelector("main>section>a")
        anchor.addEventListener("click", (e) =>{
            e.preventDefault();
            window.location.replace(url);
            /*fetch(url, {method:"POST"}).then((response)=>{
                return response.text();
            }).then(function (html) {
                //console.log(html)
                document.getElementsByTagName("html")[0].innerHTML = html
            })
                .catch(()=>{
                    alert("Ocurrió un error inesperado, contacte con un administrador...")
                })*/
        })
    }

    agregarActionFormAltas(url) {
        //const button = document.querySelector("main>section>form>button")
        const button = document.getElementById("btn-alta")
        const form = document.querySelector("main>section>form")
        button.addEventListener("click", (e) =>{
            e.preventDefault();
            fetch(url, {method:"PUT", body:JSON.stringify(form)}).then((response)=>{
                return response.text();
            }).then(function (html) {
                //console.log(html)
                //document.getElementsByTagName("html")[0].innerHTML = html
            })
                .catch(()=>{
                    alert("Ocurrió un error inesperado, contacte con un administrador...")
                })
        })
    }

    agregarLinks(url, id) {
        const btnDelete = document.getElementById("eliminar-" + id)
        const btnEdit= document.getElementById("editar-" + id)
        btnDelete.addEventListener("click", (e) =>{
            e.preventDefault();
            fetch(url, {method:"DELETE"}).then((response)=>{
                return response.text();
            }).then(function (html) {
                //console.log(html)
                document.getElementsByTagName("html")[0].innerHTML = html
            })
                .catch(()=>{
                    alert("Ocurrió un error inesperado, contacte con un administrador...")
                })
        })
        btnEdit.addEventListener("click", (e) =>{
            e.preventDefault();
            fetch(url, {method:"GET"}).then((response)=>{
                return response.text();
            }).then(function (html) {
                //console.log(html)
                document.getElementsByTagName("html")[0].innerHTML = html
            })
                .catch(()=>{
                    alert("Ocurrió un error inesperado, contacte con un administrador...")
                })
        })
    }
}

let abm = new Amb();