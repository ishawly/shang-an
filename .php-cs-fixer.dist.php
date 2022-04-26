<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('bootstrap')
    ->exclude('config')
    ->exclude('database')
    ->exclude('public')
    ->exclude('resources')
    ->exclude('storage')
    ->exclude('vendor')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony'               => true,
    'strict_param'           => true,
    'array_syntax'           => ['syntax' => 'short'],
    'binary_operator_spaces' => [
        'default' => 'align_single_space_minimal',
    ],
])->setFinder($finder);
