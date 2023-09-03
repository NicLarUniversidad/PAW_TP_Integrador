<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProductMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        //Carga mother 1
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'Motherboard Asus A320m-k Amd A320 Ryzen 1ra Gen A-series 7',
                'nombre' => 'Motherboard Asus A320m-k Amd A320 Ryzen 1ra Gen A-series 7',
                'precio_tentativo' => 90000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 11, //Motherboards
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 90000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga mother 2
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'Motherboard Asus Prime B460m-a R2.0 Intel Socket 1200 Intel Color Negro',
                'nombre' => 'Motherboard Asus Prime B460m-a R2.0 Intel Socket 1200 Intel Color Negro',
                'precio_tentativo' => 100000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 11, //Motherboards
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 100000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga procesador 1
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'AMD Ryzen 7 5700G 100-100000263BOX de 8 núcleos y 4.6GHz de frecuencia con gráfica integrada',
                'nombre' => 'AMD Ryzen 7 5700G 100-100000263BOX de 8 núcleos y 4.6GHz de frecuencia con gráfica integrada',
                'precio_tentativo' => 200000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 12, //Microprocesadores
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 200000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga procesador 2
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'Intel Core i7-4790 CM8064601560113 de 4 núcleos y 4GHz de frecuencia con gráfica integrada',
                'nombre' => 'Intel Core i7-4790 CM8064601560113 de 4 núcleos y 4GHz de frecuencia con gráfica integrada',
                'precio_tentativo' => 80000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 12, //Microprocesadores
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 80000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga RAM 1
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'RAM Fury Beast DDR4 gamer color negro 8GB 1 Kingston KF432C16BB/8',
                'nombre' => 'RAM Fury Beast DDR4 gamer color negro 8GB 1 Kingston KF432C16BB/8',
                'precio_tentativo' => 20000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 13, //RAM
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 20000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga RAM 2
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'Kingston Fury Beast DDR4 RGB KF432C16BBA/16 1 16 GB - Negro - RGB',
                'nombre' => 'Kingston Fury Beast DDR4 RGB KF432C16BBA/16 1 16 GB - Negro - RGB',
                'precio_tentativo' => 40000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 13, //RAM
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 40000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga Disco 1
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'Seagate Barracuda ST2000DM008 2 TB - Plata',
                'nombre' => 'Seagate Barracuda ST2000DM008 2 TB - Plata',
                'precio_tentativo' => 40000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 14, //Disco
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 40000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga Disco 2
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'Kingston SNV2S/500G 500 GB - Azul',
                'nombre' => 'Kingston SNV2S/500G 500 GB - Azul',
                'precio_tentativo' => 23000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 14, //Disco
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 230000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga Cooler
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => 'Cooler',
                'nombre' => 'Cooler',
                'precio_tentativo' => 23000,
                'activo' => 'SI',
                'carpeta' => 'prueba',
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

        $prodId = $this->getAdapter()->getConnection()->lastInsertId();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_producto' => $prodId,
                'id_sub_categoria' => 15, //Cooler
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();

        //Carga publicación
        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial' => 100,
                'id_producto' => $prodId,
                'precio_unidad' => 23000,
                'id_moneda' => 1
            ]
        ];

        $table->insert($rows)->saveData();

    }
}
