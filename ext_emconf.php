<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "url_transformer"
 *
 * Auto generated by Extension Builder 2019-04-30
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Url transformer',
    'description' => 'Transfrom a URL to LowerCase, convert Umlauts and redirect to the new URL',
    'category' => 'plugin',
    'author' => 'Sven Juergens',
    'author_email' => 'sj@nordsonne.de',
    'state' => 'alpha',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
