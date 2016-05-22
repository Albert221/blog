<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require 'vendor/autoload.php';

$config = Setup::createAnnotationMetadataConfiguration([__DIR__.'/src'], true); // Second argument - debug

$entityManager = EntityManager::create([
    'dbname' => 'blog',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'charset' => 'utf8',
    'driver' => 'pdo_mysql'
], $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);