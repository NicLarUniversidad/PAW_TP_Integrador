<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DbFixes extends AbstractMigration
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

        $table = $this->table("direccion_usuario");
        $table->addColumn('id_usuario', 'integer')
            ->addForeignKey('id_usuario', 'usuario', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addColumn('id_direccion', 'integer')
            ->addForeignKey('id_direccion', 'direccion', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();


        $table = $this->table('direccion');
        $table->dropForeignKey("id_codigo_postal")
            ->addColumn('codigo_postal', 'string')
            ->removeColumn("id_codigo_postal")
            ->update();
    }
}
