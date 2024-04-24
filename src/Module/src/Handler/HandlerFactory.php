<?php

declare(strict_types=1);

namespace Module\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Mezzio\Helper\UrlHelper;
use Laminas\InputFilter\InputFilterPluginManager;
use Module\InputFilter\RegistrationInputFilter;
// use Laminas\Db\Adapter\AdapterInterface;

class HandlerFactory
{
    public function __invoke(ContainerInterface $container): Handler
    {
        $inputFilterManager = $container->get(InputFilterPluginManager::class);
        $newFormFilter = $inputFilterManager->get(RegistrationInputFilter::class);
        return new Handler(
                $container->get(TemplateRendererInterface::class),
                $container->get(UrlHelper::class),
                // $container->get(AdapterInterface::class)
                $container->get('Test'),
                $newFormFilter
                // $container->get(RegistrationInputFilter::class),
            );
    }
}
