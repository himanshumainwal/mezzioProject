<?php

namespace Module\InputFilter;

use Psr\Container\ContainerInterface;

class RegistrationInputFilterFactory
{
    public function __invoke(ContainerInterface $container): RegistrationInputFilter
    {
        return new RegistrationInputFilter();
    }
}
