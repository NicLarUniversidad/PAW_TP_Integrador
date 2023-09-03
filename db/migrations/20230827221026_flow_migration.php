<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FlowMigration extends AbstractMigration
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

        $table = $this->table('armar_pc_flujo');
        $rows = [
            [
                'descripcion'  =>  "Motherboards",
                'id_sub_categoria'  =>  11,
                'numero_paso'  =>  1,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Microprocesadores",
                'id_sub_categoria'  =>  12,
                'numero_paso'  =>  2,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Memorias RAM",
                'id_sub_categoria'  =>  13,
                'numero_paso'  =>  3,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Placas de video",
                'id_sub_categoria'  =>  16,
                'numero_paso'  =>  4,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Fuentes",
                'id_sub_categoria'  =>  22,
                'numero_paso'  =>  5,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Discos",
                'id_sub_categoria'  =>  14,
                'numero_paso'  =>  6,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Coolers",
                'id_sub_categoria'  =>  15,
                'numero_paso'  =>  7,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Gabinetes",
                'id_sub_categoria'  =>  17,
                'numero_paso'  =>  8,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Monitores",
                'id_sub_categoria'  =>  18,
                'numero_paso'  =>  9,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Auriculares",
                'id_sub_categoria'  =>  19,
                'numero_paso'  =>  10,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Mouses",
                'id_sub_categoria'  =>  20,
                'numero_paso'  =>  11,
                'activo' => 'SI'
            ],
            [
                'descripcion'  =>  "Teclados",
                'id_sub_categoria'  =>  21,
                'numero_paso'  =>  12,
                'activo' => 'SI'
            ]
        ];
        $table->insert($rows)->saveData();
    }
}
