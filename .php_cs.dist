<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('messages')
    ->in(__DIR__ . '/protected/an602');

return PhpCsFixer\Config::create()
    ->setRules([
        'array_syntax' => ['syntax' => 'short'],
        'elseif' => true,
        'lowercase_constants' => true,
    ])
    ->setFinder($finder);
