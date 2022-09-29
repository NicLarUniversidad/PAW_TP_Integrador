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
            ]
        ];
        $table->insert($rows)->saveData();
    }
}
