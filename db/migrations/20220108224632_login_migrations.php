<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class LoginMigrations extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("persona");
        $table->removeIndex("id_direccion")
            ->removeColumn("id_direccion")
            ->addColumn("direccion", "string")
            ->update();
    }
}
