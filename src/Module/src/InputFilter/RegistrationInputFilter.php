<?php

namespace Module\InputFilter;

use Laminas\InputFilter\InputFilter;

class RegistrationInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'fName',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-zA-Z]*$/',
                        'messages' => [
                            'regexNotMatch' => 'Full name must contain only letters',
                        ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
                        'messages' => [
                            'regexNotMatch' => 'Invalid email address',
                        ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'pass',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'messages' => [
                            'regexNotMatch' => 'Password is invalid',
                        ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'confirmPass',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'messages' => [
                            'regexNotMatch' => 'Password is invalid',
                        ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'mobileNumber',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[0-9]{10}$/',
                        'messages' => [
                            'regexNotMatch' => 'Mobile number is invalid',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
