# PAW TP Integrador

## Descripción

[Sistema tienda virtual](propuestas/tiendaVritual.md)

## Figma

[Link a web](https://www.figma.com/files/project/33268174/Team-project?fuid=888522011888423886)


[Link secundario](https://www.figma.com/file/FgawfllMkwyFLRsrzFRfwW/Untitled?node-id=0%3A1)

## Modelo de datos

[DER en draw.io](https://drive.google.com/file/d/1mYB9B2K3Yq20m6xe4iRQhX1s6F8JGkS-/view?usp=sharing)

[Comentarios DER](/Documentación/DER.md)


## Instalación

### Base de datos

### Mercado Pago

Se requiere configurar certificados, en Windows se puede descargar el archivo desde
https://curl.se/docs/caextract.html

Y luego, en el archivo php.ini. Agregar la referencia a donde se guardó localmente este archivo en las variables:
curl.cainfo
openssl.cafile