addEventListener('DOMContentLoaded', () => {

	const imagenes = ['img/portada1.jpg','img/portada3.jpg']

				let i=1 /*controla sobre que imagen estoy*/
				const img1 = document.querySelector('#img1')
				const img2 = document.querySelector('#img2')
				const progressBar = document.querySelector('#progress-bar')
				const divIndicadores = document.querySelector('#indicadores')
				let porcentaje_base = 100/imagenes.length /**/
				let porcentaje_actual = porcentaje_base

				for (let index = 0; index < imagenes.length; index++){
					const div = document.createElement('div') /*creamos los divs*/
					div.classList.add('circles')
					div.id = index /*para identificar el circulo a colorear*/
					divIndicadores.appendChild(div)

				}


				progressBar.style.width = '${porcentaje_base}%' /*tamaño de la barra*/
				img1.src = imagenes[0] /*primera imagen a cargar*/
				const circulos = document.querySelectorAll('.circles')
				circulos[0].classList.add('resaltado')

				const slideshow = () =>{ /*funcion que cambia imagenes*/
					img2.src = imagenes[i]
					const circulo_actual = Array.from(circulos).find(el => el.id == i) /*buscamos el elemento dentro de la lista */
					Array.from(circulos).forEach(cir=>cir.classList.remove('resaltado'))/*removemos el circulo resaltado de todos los elementos*/
					circulo_actual.classList.add('resaltado')/*resaltamos el actual*/

					img2.classList.add('active') /*asignamos active a la imagen 2*/
					i++
					porcentaje_actual+=porcentaje_base /*sumamos pocentajes para que muestre la siguiente imagen*/
					progressBar.style.width = '${porcentaje_actual}%'
					if (i== imagenes.length){/*bucle para volver a la primera imagen*/
						i=0;
						porcentaje_actual = porcentaje_base - porcentaje_base

					}


					setTimeout(() => {/*la imagen anterior toma la siguiente*/
						img1.src = img2.src
						img2.classList.remove('active')
					},1000)/*se ejecuta cada 1 segundo*/
				}


			setInterval(slideshow, 4000)/*cada 4s se ejecuta la funcion*/

})