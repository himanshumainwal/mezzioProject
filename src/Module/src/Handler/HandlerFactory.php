<?php

declare(strict_types=1);

namespace Module\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Mezzio\Helper\UrlHelper;

class HandlerFactory
{
    public function __invoke(ContainerInterface $container): Handler
    {
        return new Handler(
                $container->get(TemplateRendererInterface::class),
                $container->get(FirstModel::class),
                $container->get(UrlHelper::class)
                // $container->get('config')
            );
    }
}
