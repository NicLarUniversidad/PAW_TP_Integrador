# Tienda virtual

Proponemos desarrollar una aplicación web para un local de electrodomésticos. La motivación del trabajo es que nos puede ser útil como un inicio para poder generar algún ingreso en el futuro.

Se apunta a que un usuario pueda buscar un producto a través de su nombre o descripción y que luego pueda comprarlo. Se puede usar una API como Mercado Pago para procesar los pagos.
_____________________________
Se definen dos tipos de usuarios:
* Usuario externo: puede comprar.

* Usuario backoffice o administrativo: tareas gestión.
_____________________________
Se podría tener una misma aplicación en el back, pero con diferentes clientes que accedan a diferentes endpoints.
De modo que un usuario tenga logearse de forma independiente en cada cliente.

_____________________________
Tenemos que tener una vista para listar los paquetes que se deben enviar. O sea, las compras de los `usuario externos`.

_____________________________
Se propone una sección para poder armar una PC seleccionando todos sus componentes.  Basada en la siguiente [página](https://compragamer.com/armatupc/?listado_prod=undefined&nro_max=50).

_____________________________
Los `usuarios externos` podrán buscar productos a través de una serie de categorías asociadas a los mismos. También, abrán una serie de características por las que también se podrán buscar.

_____________________________
Habrá una vista de categoría para poder buscar de otra forma un producto.

_____________________________
Las categorías y características podrán ser definidas por los `usuarios de backoffice`.