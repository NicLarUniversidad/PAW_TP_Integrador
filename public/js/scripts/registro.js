class Registro {
    addPostEvents() {
        let item = document.querySelector("form");
        item.addEventListener("submit", async (e) => {
            e.preventDefault();
            let values = new FormData(item);
            let response = await fetch(
                "registrarse"
                ,
                {
                    method: "POST",
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: values.get("username"),
                        password: values.get("password"),
                        re_password: values.get("re-password"),
                        mail: values.get("mail"),
                        nombre: values.get("nombre"),
                        apellido: values.get("apellido"),
                    })
                }
            );
            let message = await response.text();
            if (message == "OK") {
                alert("Se ha creado el usuario correctamente");
                window.location.replace("/login")
                return false;
            } else {
                let modal = document.querySelector("#modal");
                let p =  document.querySelector("section > p");
                p.innerHTML = message;
                modal.classList.remove("hidden");
                modal.classList.add("modal");
            }
        });

        let button = document.querySelector("section > button");
        button.addEventListener("click", () => {
            let modal = document.querySelector("#modal");
            modal.classList.add("hidden");
            modal.classList.remove("modal");
        });
    }
}



document.addEventListener("DOMContentLoaded",()=>{
    let registro = new Registro();
    registro.addPostEvents();
});