<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('login', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('nome', 'string', ['limit' => 255])
            ->addColumn('senha', 'string', ['limit' => 255])
            ->addIndex(['login'], ['unique' => true])
            ->create();
    }
}
