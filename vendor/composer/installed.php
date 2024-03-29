<?php return array(
    'root' => array(
        'name' => 'dev-alamin/book-review',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '06936b71e9ef72eb4490a65e06bbb69b5915da26',
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '2a9170263fcd9cc4fd0b50917293c21d6c1a5bfe',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(
                0 => '2.x-dev',
            ),
            'dev_requirement' => false,
        ),
        'dev-alamin/book-review' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '06936b71e9ef72eb4490a65e06bbb69b5915da26',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'htmlburger/carbon-fields' => array(
            'pretty_version' => 'v3.6.3',
            'version' => '3.6.3.0',
            'reference' => 'd913a5148cb9dc61ed239719c747f4ebb513003f',
            'type' => 'library',
            'install_path' => __DIR__ . '/../htmlburger/carbon-fields',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'htmlburger/carbon-fields-plugin' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => '35e4524835863ff43671f14baecf7f263c16521a',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../wp-content/plugins/carbon-fields-plugin',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
    ),
);
