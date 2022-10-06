<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NewCargaProductos extends AbstractMigration
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
        $table = $this->table('producto');
        $rows = [
            [
                'descripcion' => "Socket: AM4 Ryzen 3th Gen,AM4 APU 3th Gen,AM4 Ryzen 4th Gen,AM4 APU 50",
                'nombre' => 'Mother ASUS PRIME A520M-K AM4',
                'activo' => 'SI',
                'precio_tentativo' => 15.100,
                'carpeta' => 'mothearboard',
                'id_moneda' => 1
            ],
            [
                'descripcion' => "El freezer Sigma FH2600BP tiene un diseño tradicional horizontal en color blanco. Para organizar mejor los productos almacenados, cuenta con un canasto plástico de colgar.El volumen total del freezer es de 223 litros.",
                'nombre' => 'Freezer Sigma FH2600BPa 223Lt',
                'activo' => 'SI',
                'precio_tentativo' => 70.000,
                'carpeta' => 'freezers',
                'id_moneda' => 1
            ]

            //Segundo producto[]
        ];
        $table->insert($rows)->saveData();

        $table = $this->table('publicacion');
        $rows = [
            [
                'cantidad_inicial'  =>  6,
                'id_producto'  =>  2,
                'precio_unidad' => 81.999,
                'id_moneda'  =>  1
            ]

            //Segundo producto[]
        ];
        $table->insert($rows)->saveData();


        $table = $this->table('grupo_categoria');
        $rows = [
            [
                'descripcion' => 'Mother y mas',
                'activo' => 'SI',
            ],
            [
                'descripcion' => 'Memorias RAM',
                'activo' => 'SI',
            ],
            [
                'descripcion' => 'Placas de video y otras',
                'activo' => 'SI',
            ],
            [
                'descripcion' => 'Monitores y Televisores',
                'activo' => 'SI',
            ],
            [
                'descripcion' => 'Audio',
                'activo' => 'SI',
            ],
            [
                'descripcion' => 'Electrodomésticos',
                'activo' => 'SI',
            ],
            [
                'descripcion' => 'Herramientas y Jardín',
                'activo' => 'SI',
            ],
            [
                'descripcion' => 'Hogar y Muebles',
                'activo' => 'SI',
            ]
        ];
        $table->insert($rows)->saveData();

        $table = $this->table('categoria');
        $rows = [
            [
                'descripcion' => 'Motherboard',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 1
            ],
            [
                'descripcion' => 'Memorias',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 2
            ],
            [
                'descripcion' => 'Memorias Sodimm',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 2
            ],
            [
                'descripcion' => 'Auriculares',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 5
            ],
            [
                'descripcion' => 'Parlantes',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 5
            ],
            [
                'descripcion' => 'Cocinas y Hornos',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 6
            ],
            [
                'descripcion' => 'Heladeras, Freezers y Cavas',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 6
            ],
            [
                'descripcion' => 'Lavado',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 6
            ],
            [
                'descripcion' => 'Herramientas eléctricas',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 7
            ],
            [
                'descripcion' => 'Herramientas manuales',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 7
            ],
            [
                'descripcion' => 'Muebles de jardín',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 7
            ],
            [
                'descripcion' => 'Decoración',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 8
            ],
            [
                'descripcion' => 'Muebles',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 8
            ],
            [
                'descripcion' => 'Iluminación',
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 8
            ]
        ];
        $table->insert($rows)->saveData();

        $table = $this->table('sub_categoria');
        $rows = [
            [
                'descripcion' => 'Parlantes portátiles',
                'activo' => 'SI',
                'id_categoria' => 5
            ],
            [
                'descripcion' => 'Home Theater',
                'activo' => 'SI',
                'id_categoria' => 5
            ],
            [
                'descripcion' => 'Equipos de Audio',
                'activo' => 'SI',
                'id_categoria' => 5
            ],
            [
                'descripcion' => 'Cocinas',
                'activo' => 'SI',
                'id_categoria' => 6
            ],
            [
                'descripcion' => 'Hornos',
                'activo' => 'SI',
                'id_categoria' => 6
            ],
            [
                'descripcion' => 'Microondas',
                'activo' => 'SI',
                'id_categoria' => 6
            ],
            [
                'descripcion' => 'Heladeras con freezer',
                'activo' => 'SI',
                'id_categoria' => 7
            ],
            [
                'descripcion' => 'Heladeras sin freezer',
                'activo' => 'SI',
                'id_categoria' => 7
            ],
            [
                'descripcion' => 'Freezers',
                'activo' => 'SI',
                'id_categoria' => 7
            ],
            [
                'descripcion' => 'Cavas y exhibidoras',
                'activo' => 'SI',
                'id_categoria' => 7
            ]

        ];
        $table->insert($rows)->saveData();


        $table = $this->table('producto_sub_categoria');
        $rows = [
            [
                'id_sub_categoria'  =>  9,
                'id_producto'  =>  2,
                'activo' => 'SI'
            ]

            //Segundo producto[]
        ];
        $table->insert($rows)->saveData();

        $table = $this->table('oferta');
        $rows = [
            [
                'precio_oferta'  =>  50.000,
                'activa'  =>  'SI',
                'id_publicacion'  =>  1
            ]

            //Segundo producto[]
        ];
        $table->insert($rows)->saveData();


    }
}
