<?php

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['LOG']['SvenJuergens']['Miniredirect']['writerConfiguration'] = [
    \TYPO3\CMS\Core\Log\LogLevel::INFO => [
        \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
            'logFileInfix' => 'miniredirect'
        ]
    ]
];