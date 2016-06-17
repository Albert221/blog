<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require 'vendor/autoload.php';

$config = require 'config/config.php';

$configConnection = $config['database'];
$config = Setup::createAnnotationMetadataConfiguration([__DIR__.'/src'], $config['debug']); // Second argument - debug

$entityManager = EntityManager::create($configConnection, $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
