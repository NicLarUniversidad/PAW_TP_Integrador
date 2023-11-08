<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Ventas extends AbstractMigration
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
        $table = $this->table('solicitud-venta');
        $table->addColumn('id_carrito', 'integer')
            ->addForeignKey('id_carrito', 'carrito', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addColumn('idPago', 'string')
            ->addColumn('estado', 'string')
            ->addColumn('activo', 'string')
            ->create();

        $table = $this->table('venta');
        $table->addColumn('id_carrito', 'integer')
            ->addForeignKey('id_carrito', 'carrito', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addColumn('id_usuario', 'integer')
            ->addForeignKey('id_usuario', 'usuario', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addColumn('estado', 'string')
            ->addColumn('monto', 'float', [ 'length' => 10, 'precision' => 2])
            ->addColumn('fechaPago', 'datetime')
            ->addColumn('activo', 'string')
            ->create();

        $table = $this->table('detalleVenta');
        $table->addColumn('id_venta', 'integer')
            ->addForeignKey('id_venta', 'venta', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addColumn('id_publicacion', 'integer')
            ->addForeignKey('id_publicacion', 'publicacion', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addColumn('monto', 'float', [ 'length' => 10, 'precision' => 2])
            ->addColumn('activo', 'string')
            ->create();
    }
}
