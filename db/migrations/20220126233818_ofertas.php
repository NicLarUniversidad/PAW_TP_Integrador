<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Ofertas extends AbstractMigration
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
        $table = $this->table('oferta');
        $table->addColumn('precio_oferta', 'float')
            ->addColumn('activa', 'string')
            ->addColumn('id_publicacion', 'integer')
            ->addForeignKey('id_publicacion', 'publicacion', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
