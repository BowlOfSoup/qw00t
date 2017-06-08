<?php

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'concat_space' => false,
        'array_syntax' => true,
        'blank_line_after_opening_tag' => true,
        'ordered_imports' => true,
        'phpdoc_align' => false,
        'phpdoc_inline_tag' => false,
        'phpdoc_order' => true,
        'simplified_null_return' => false,
        'no_multiline_whitespace_around_double_arrow' => false,
        'standardize_not_equals' => false,
        'no_unused_imports' => false,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['vendor', 'web'])
            ->in(__DIR__)
    );