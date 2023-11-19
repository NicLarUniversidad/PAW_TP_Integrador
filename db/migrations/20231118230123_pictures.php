<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Pictures extends AbstractMigration
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
        //Carga fotos
        $table = $this->table('fotografia_producto');
        $rows = [
            [
                'id' => 1,
                'id_producto' => 5,
                'url' => "documentos/initialSeed/ryzen7-1.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 2,
                'id_producto' => 5,
                'url' => "documentos/initialSeed/ryzen7-2.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 3,
                'id_producto' => 5,
                'url' => "documentos/initialSeed/ryzen7-3.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 4,
                'id_producto' => 2,
                'url' => "documentos/initialSeed/Freezer-Sigma-1.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 5,
                'id_producto' => 2,
                'url' => "documentos/initialSeed/Freezer-Sigma-2.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 6,
                'id_producto' => 2,
                'url' => "documentos/initialSeed/Freezer-Sigma-3.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 7,
                'id_producto' => 3,
                'url' => "documentos/initialSeed/asus-a320m-1.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 8,
                'id_producto' => 3,
                'url' => "documentos/initialSeed/asus-a320m-2.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 9,
                'id_producto' => 4,
                'url' => "documentos/initialSeed/asus-b460m-1.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 10,
                'id_producto' => 4,
                'url' => "documentos/initialSeed/asus-b460m-2.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 11,
                'id_producto' => 4,
                'url' => "documentos/initialSeed/asus-b460m-3.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 12,
                'id_producto' => 6,
                'url' => "documentos/initialSeed/ryzen7-1.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 13,
                'id_producto' => 6,
                'url' => "documentos/initialSeed/ryzen7-2.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 14,
                'id_producto' => 6,
                'url' => "documentos/initialSeed/ryzen7-3.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 15,
                'id_producto' => 7,
                'url' => "documentos/initialSeed/ram-fury-1.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 16,
                'id_producto' => 7,
                'url' => "documentos/initialSeed/ram-fury-2.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 17,
                'id_producto' => 7,
                'url' => "documentos/initialSeed/ram-fury-3.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 18,
                'id_producto' => 8,
                'url' => "documentos/initialSeed/ram-fury-1.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 19,
                'id_producto' => 8,
                'url' => "documentos/initialSeed/ram-fury-2.jpg",
                'activo' => 'SI'
            ],
            [
                'id' => 20,
                'id_producto' => 8,
                'url' => "documentos/initialSeed/ram-fury-3.jpg",
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();
    }
}
