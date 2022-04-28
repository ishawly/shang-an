<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('bootstrap')
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
    // imports
    'no_unused_imports' => false,
    // trait
    'single_trait_insert_per_statement' => false,
    // phpdoc
    'no_superfluous_phpdoc_tags' => false,
    'phpdoc_separation'          => false,
    // string
    'concat_space' => ['spacing' => 'one'],    // none, one
    // php unit
    'php_unit_method_casing' => ['case' => 'snake_case'], // default: camel_case
])->setFinder($finder);
