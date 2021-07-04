<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MigracionInicial extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('grupo_categoria');
        $table->addColumn('descripcion', 'string')
            ->addColumn('activo', 'string')
            ->create();
        $table = $this->table('categoria');
        $table->addColumn('descripcion', 'string')
            ->addColumn('activo', 'string')
            ->addColumn('id_grupo_categoria', 'integer')
            ->addForeignKey('id_grupo_categoria', 'grupo_categoria', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('sub_categoria');
        $table->addColumn('descripcion', 'string')
            ->addColumn('activo', 'string')
            ->addColumn('id_categoria', 'integer')
            ->addForeignKey('id_categoria', 'categoria', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('caracteristica');
        $table->addColumn('descripcion', 'string')
            ->addColumn('activo', 'string')
            ->create();
        $table = $this->table('sub_categoria_caracteristica');
        $table->addColumn('id_sub_categoria', 'integer')
            ->addColumn('id_caracteristica', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_sub_categoria', 'sub_categoria', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_caracteristica', 'caracteristica', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('valor_caracteristica');
        $table->addColumn('descripcion', 'string')
            ->addColumn('tipo', 'string')
            ->addColumn('activo', 'string')
            ->addColumn('id_caracteristica', 'integer')
            ->addForeignKey('id_caracteristica', 'caracteristica', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('moneda');
        $table->addColumn('nombre', 'string')
            ->addColumn('activo', 'string')
            ->create();
        $table = $this->table('producto');
        $table->addColumn('descripcion', 'string')
            ->addColumn('activo', 'string')
            ->addColumn('precio_tentativo', 'float')
            ->addColumn('carpeta', 'string')
            ->addColumn('id_moneda', 'integer')
            ->addForeignKey('id_moneda', 'moneda', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('stock');
        $table->addColumn('fecha_entrada', 'date')
            ->addColumn('cantidad_inicial', 'integer')
            ->addColumn('costo_unidad', 'float')
            ->addColumn('precio_unidad', 'float')
            ->addColumn('id_producto', 'integer')
            ->addColumn('id_moneda', 'integer')
            ->addForeignKey('id_producto', 'producto', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_moneda', 'moneda', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('producto_sub_categoria');
        $table->addColumn('id_sub_categoria', 'integer')
            ->addColumn('id_pruducto', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_sub_categoria', 'sub_categoria', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_producto', 'producto', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('caracteristica_producto');
        $table->addColumn('id_caracteristica', 'integer')
            ->addColumn('id_pruducto', 'integer')
            ->addColumn('id_valor_caracteristica', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_caracteristica', 'caracteristica', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_pruducto', 'producto', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_valor_caracteristica', 'valor_caracteristica', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('publicacion');
        $table->addColumn('fecha_entrada', 'date')
            ->addColumn('cantidad_inicial', 'integer')
            ->addColumn('id_producto', 'integer')
            ->addColumn('precio_unidad', 'float')
            ->addColumn('id_moneda', 'integer')
            ->addForeignKey('id_producto', 'producto', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_moneda', 'moneda', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('codigo_postal');
        $table->addColumn('codigo', 'integer')
            ->addColumn('costo_envio', 'float')
            ->addColumn('id_moneda', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_moneda', 'moneda', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('direccion');
        $table->addColumn('provincia', 'string')
            ->addColumn('ciudad', 'string')
            ->addColumn('localidad', 'string')
            ->addColumn('calle', 'string')
            ->addColumn('numero', 'string')
            ->addColumn('medio', 'string')
            ->addColumn('piso', 'string')
            ->addColumn('departamento', 'string')
            ->addColumn('id_codigo_postal', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_codigo_postal', 'codigo_postal', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('persona');
        $table->addColumn('nombre', 'string')
            ->addColumn('apellido', 'string')
            ->addColumn('mail', 'string')
            ->addColumn('id_direccion', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_direccion', 'direccion', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('usuario');
        $table->addColumn('username', 'string')
            ->addColumn('password', 'string')
            ->addColumn('mail', 'string')
            ->addColumn('id_persona', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_persona', 'persona', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('pregunta');
        $table->addColumn('pregunta', 'string')
            ->addColumn('respuesta', 'string')
            ->addColumn('fecha_pregunta', 'date')
            ->addColumn('fecha_respuesta', 'date')
            ->addColumn('valoracion_respuesta', 'string')
            ->addColumn('id_publicacion', 'integer')
            ->addColumn('id_usuario_pregunta', 'integer')
            ->addColumn('id_usuario_respuesta', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_publicacion', 'publicacion', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_usuario_pregunta', 'usuario', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_usuario_respuesta', 'usuario', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('carrito');
        $table->addColumn('precio_total', 'float')
            ->addColumn('id_direccion', 'integer')
            ->addColumn('id_usuario', 'integer')
            ->addColumn('id_moneda', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_direccion', 'direccion', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_usuario', 'usuario', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_moneda', 'moneda', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('item_carrito');
        $table->addColumn('precio_unidad', 'float')
            ->addColumn('cantidad', 'integer')
            ->addColumn('id_publicacion', 'integer')
            ->addColumn('id_carrito', 'integer')
            ->addColumn('id_moneda', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_publicacion', 'publicacion', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_carrito', 'carrito', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_moneda', 'moneda', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('compra_impaga');
        $table->addColumn('fecha_inicio', 'date')
            ->addColumn('cantidad', 'integer')
            ->addColumn('estado', 'string')
            ->addColumn('id_carrito', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_carrito', 'carrito', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('compra_pagada');
        $table->addColumn('fecha_pago', 'date')
            ->addColumn('cantidad', 'integer')
            ->addColumn('estado', 'string')
            ->addColumn('id_compra_impaga', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_compra_impaga', 'compra_impaga', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('compra_enviada');
        $table->addColumn('fecha_envio', 'date')
            ->addColumn('cantidad', 'integer')
            ->addColumn('estado', 'string')
            ->addColumn('id_compra_pagada', 'integer')
            ->addColumn('activo', 'string')
            ->addForeignKey('id_compra_pagada', 'compra_pagada', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('rol');
        $table->addColumn('nombre', 'string')
            ->create();
        $table = $this->table('permiso');
        $table->addColumn('nombre', 'string')
            ->create();
        $table = $this->table('rol_usuario');
        $table->addColumn('id_rol', 'integer')
            ->addColumn('id_usuario', 'integer')
            ->addForeignKey('id_rol', 'rol', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_usuario', 'usuario', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('rol_permiso');
        $table->addColumn('id_rol', 'integer')
            ->addColumn('id_permiso', 'integer')
            ->addForeignKey('id_rol', 'rol', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('id_permiso', 'permiso', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
        $table = $this->table('fotografia_producto');
        $table->addColumn('id_producto', 'integer')
            ->addColumn('url', 'string')
            ->addForeignKey('id_producto', 'producto', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
