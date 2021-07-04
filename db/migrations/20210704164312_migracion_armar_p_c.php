<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MigracionArmarPC extends AbstractMigration
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
        $table->addColumn('descripcion', 'string')
            ->addColumn('activo', 'string')
            ->addColumn('id_sub_categoria', 'integer')
            ->addColumn('numero_paso', 'integer')
            ->addForeignKey('id_sub_categoria', 'sub_categoria', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();

        $table = $this->table('restriccion');
        $table->addColumn('descripcion', 'string')
            ->addColumn('activo', 'string')
            ->addColumn('id_flujo', 'integer')
            ->addColumn('id_caracteristica', 'integer')
            ->addColumn('operador', 'string')
            ->addColumn('constante', 'string')
            ->addForeignKey('id_flujo', 'armar_pc_flujo', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_caracteristica', 'caracteristica', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
