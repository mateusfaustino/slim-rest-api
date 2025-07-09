<?php

declare(strict_types=1);

use DI\Container;
use Infrastructure\Database\Database;
use Domain\Produto\ProdutoRepository;
use Infrastructure\Persistence\PdoProdutoRepository;
use Domain\Usuario\UsuarioRepository;
use Infrastructure\Persistence\PdoUsuarioRepository;
use PDO;

return function (Container $container): void {
    $container->set(PDO::class, function () {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $name = $_ENV['DB_NAME'] ?? 'app';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';

        $db = new Database($host, $name, $user, $pass);
        return $db->getConnection();
    });

    $container->set(ProdutoRepository::class, DI\autowire(PdoProdutoRepository::class));
    $container->set(UsuarioRepository::class, DI\autowire(PdoUsuarioRepository::class));
};
