<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NewStatusMigration extends AbstractMigration
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
    public function up()
    {
        $table = $this->table('moneda');

        // inserting only one row
        $singleRow = [
            'nombre'  => 'Pesos',
            'activo' => 'SI'
        ];

        $table->insert($singleRow)->saveData();

        // inserting multiple rows
        $table = $this->table('codigo_postal');
        $rows = [
            [
                'codigo'    => 1727,
                'costo_envio'  => 600,
                'id_moneda' => 1,
                'activo' => 'SI'
            ],
            [
                'codigo'    => 1780,
                'costo_envio'  => 700,
                'id_moneda' => 1,
                'activo' => 'SI'
            ],
            [
                'codigo'    => 1600,
                'costo_envio'  => 600,
                'id_moneda' => 1,
                'activo' => 'SI'
            ],
            [
                'codigo'    => 1720,
                'costo_envio'  => 540,
                'id_moneda' => 1,
                'activo' => 'SI'
            ]
        ];

        $table->insert($rows)->saveData();
        $table = $this->table('direccion');
        $rows = [
            [
                'provincia'    => "Buenos Aires",
                'ciudad'  => "Lujan",
                'localidad' => "Lujan",
                'calle' => 'calle falsa',
                'numero' => '123',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 1,
                'activo' => 'SI',

            ],
            [
                'provincia'    => "Buenos Aires",
                'ciudad'  => "Marcos Paz",
                'localidad' => "Marcos Paz",
                'calle' => 'Libertad',
                'numero' => '123',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 1,
                'activo' => 'SI',

            ],
            [
                'provincia'    => "La Rioja",
                'ciudad'  => "La Rioja",
                'localidad' => "Localidad",
                'calle' => 'calle123',
                'numero' => '123',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 2,
                'activo' => 'SI',

            ],
            [
                'provincia'    => "La Rioja",
                'ciudad'  => "La Rioja",
                'localidad' => "Localidad",
                'calle' => 'calle 33',
                'numero' => '1233',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 2,
                'activo' => 'SI',

            ],
            [
                'provincia'    => "La Rioja",
                'ciudad'  => "La Rioja",
                'localidad' => "La Rioja",
                'calle' => 'calle123',
                'numero' => '123',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 2,
                'activo' => 'SI',

            ],
            [
                'provincia'    => "Buenos Aires",
                'ciudad'  => "Ciudad de Buenos Aires",
                'localidad' => "Buenos Aires",
                'calle' => 'Av. 9 de Julio',
                'numero' => '33',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 2,
                'activo' => 'SI',

            ],
            [
                'provincia'    => "Mendoza",
                'ciudad'  => "Lujan de Cuyo",
                'localidad' => "Lujan de cuyo",
                'calle' => 'calle23',
                'numero' => '13',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 3,
                'activo' => 'SI',

            ],
            [
                'provincia'    => "Santa Fe",
                'ciudad'  => "Rosario",
                'localidad' => "Rosario",
                'calle' => 'calle 33',
                'numero' => '1232',
                'medio' => '',
                'piso' => '',
                'departamento' => '',
                'id_codigo_postal' => 3,
                'activo' => 'SI',

            ]

        ];
        $table->insert($rows)->saveData();
    }

    public function down()
    {
        $this->execute('DELETE FROM status');
    }
}
