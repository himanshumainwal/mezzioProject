<?php 

declare(strict_types=1);

namespace Module\Handler;
use Psr\Container\ContainerInterface;


class FirstModelFactory{
    
    public function __invoke(ContainerInterface $container): FirstModel
    {
        return new FirstModel(
                $container->get('TEST'), // if database exists then return array
            );
    }
}