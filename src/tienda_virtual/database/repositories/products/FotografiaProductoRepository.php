<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\repositories\Repository;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\exceptions\IndexNotFoundException;
use src\tienda_virtual\exceptions\PageNotFoundException;
use src\tienda_virtual\services\FileService;

class FotografiaProductoRepository extends Repository
{
    private FileService $fileService;
    private ProductoService $productoService;

    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "fotografia_producto", "products\\FotografiaProductoModel");
        $this->productoService = new ProductoService($connection, $logger);
        $this->fileService = new FileService();
    }

    public function findByProducto(array $producto) : array {
        $model = new $this->modelo();
        if (count($producto) > 0) {
            return $this->queryBuilder->select($model->getTableFields())
                ->from($this->tabla)
                ->where(["id_producto" => $producto[0]["id"]])
                ->execute();
        }
        else {
            return [];
        }
    }

    /**
     * @throws IndexNotFoundException
     * @throws PageNotFoundException
     */
    public function save(Model $model) : void {
        $producto = $this->productoService->find($model->getField("id_producto"));
        $fotos = $this->findByProducto($producto);
        $archivo = $this->fileRequest->get("abm-url");
        if (count($producto) > 0) {
            $url = $this->fileService->save($producto[0]["carpeta"], (count($fotos) + 1) . ".jpg", $archivo, file_get_contents($archivo['tmp_name']));
            $model->setField("url", $url);
            parent::save($model);
        } else {
            //TODO: manejar que hacer acá
            throw new PageNotFoundException();
        }
    }
}