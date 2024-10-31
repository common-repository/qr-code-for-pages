<?php return array(
    'root' => array(
        'name' => 'me-team/me-qr-plugin',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '5ca4c55ec8e45dc6311017bba1ab12eb22fc276a',
        'type' => 'composer-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'me-team/me-qr-plugin' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '5ca4c55ec8e45dc6311017bba1ab12eb22fc276a',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'psr/container' => array(
            'pretty_version' => '2.0.2',
            'version' => '2.0.2.0',
            'reference' => 'c71ecc56dfe541dbd90c5360474fbc405f8d5963',
            'type' => 'library',
            'install_path' => __DIR__ . '/../psr/container',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'roave/security-advisories' => array(
            'pretty_version' => 'dev-latest',
            'version' => 'dev-latest',
            'reference' => 'ef9dca6c49faa06e7203bbed30411e26e474a8fb',
            'type' => 'metapackage',
            'install_path' => NULL,
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => true,
        ),
    ),
);
