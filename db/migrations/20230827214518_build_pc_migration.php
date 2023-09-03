<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class BuildPcMigration extends AbstractMigration
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

        $table = $this->table('categoria');
        $rows = [
            [
                'descripcion' => 'Componentes PC',//ID=15
                'url' => '',
                'activo' => 'SI',
                'id_grupo_categoria' => 1
            ]
            ];

        $table->insert($rows)->saveData();

        $catId = $this->getAdapter()->getConnection()->lastInsertId();

        $table = $this->table('sub_categoria');
        $rows = [
            [
                'descripcion' => 'Motherboards',//ID=11
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Microprocesadores',//ID=12
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Memorias RAM',//ID=13
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Discos',//ID=14
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Coolers',//ID=15
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Placas de video',//ID=16
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Gabinetes',//ID=17
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Monitores',//ID=18
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Auriculares',//ID=19
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Mouses',//ID=20
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Teclados',//ID=21
                'activo' => 'SI',
                'id_categoria' => $catId
            ],
            [
                'descripcion' => 'Fuentes',//ID=22
                'activo' => 'SI',
                'id_categoria' => $catId
            ]
        ];

        $table->insert($rows)->saveData();
    }
}
