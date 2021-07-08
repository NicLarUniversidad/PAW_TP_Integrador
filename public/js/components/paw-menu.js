class PAWMenu{
    constructor(pContenedor){

        let contenedor = pContenedor.tagName
            ? pContenedor 
            : document.querySelector(pContenedor);
        
        if(contenedor) {
            contenedor.classList.add("PAW-Menu");
            contenedor.classList.add("PAW-MenuCerrado");

            document.head.appendChild(PAW.nuevoElemento("link","",{rel:"stylesheet", type: "text/css" ,href: "js/components/styles/menu-style.css"}));

            PAW.nuevoElemento("link",
                {href: "paw-menu.js"}
            );
            let boton = PAW.nuevoElemento("button", "", {
				class: "PAW-MenuAbrir",
			});
            
            let buttonMenu= document.getElementById("button-menu");
            buttonMenu.classList.add("PAW-MenuAbrir");
            buttonMenu.classList.add("PAW-Button-Menu");
            buttonMenu.addEventListener("click", (event)=>{
                //agregado
                if (event.target.classList.contains("PAW-MenuAbrir")) {
					event.target.classList.add("PAW-MenuCerrar");
					event.target.classList.remove("PAW-MenuAbrir");
					contenedor.classList.add("PAW-MenuAbierto");
					contenedor.classList.remove("PAW-MenuCerrado");
				} else {
					event.target.classList.add("PAW-MenuAbrir");
					event.target.classList.remove("PAW-MenuCerrar");
					contenedor.classList.add("PAW-MenuCerrado");
					contenedor.classList.remove("PAW-MenuAbierto");
				}
                   
                console.log(event);
            });
        }else{
            console.error("Elemento no encontrado");
        }

    }

}