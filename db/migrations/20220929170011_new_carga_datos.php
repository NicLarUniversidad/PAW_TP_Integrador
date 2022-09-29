<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NewCargaDatos extends AbstractMigration
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
        $table = $this->table('rol');

        // inserting only one row
        $rows = [
            [
                'nombre' => 'user'
            ],
            [
                'nombre' => 'admin'
            ]
        ];

        $table->insert($rows)->saveData();
        

        $table = $this->table('persona');
        $rows = [
            [
                'nombre' => 'admin',
                'apellido' => 'admin',
                'mail' => 'admin@test.com',
                'id_direccion' => 1,
                'activo' => 'SI'
            ]
        ];
        $table->insert($rows)->saveData();

        $password = 'admin_paw';
        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $table = $this->table('usuario');
        $rows = [
            [
                'username' => 'admin',
                'password' => $password,
                'mail' => 'admin@test.com',
                'id_persona' => 1,
                'activo' => 'SI'
            ]
        ];
        $table->insert($rows)->saveData();


        $table = $this->table('rol_usuario');
        $rows = [
            [
                'id_rol' => 1,
                'id_usuario' => 1
            ]
        ];
        $table->insert($rows)->saveData();

    }

}
