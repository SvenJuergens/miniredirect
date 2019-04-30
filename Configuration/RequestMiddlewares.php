<?php

/**
 * Definitions for middlewares provided by EXT:url_transformer
 */
return [
    'frontend' => [
        'svenjuergens/urltransformer' => [
            'target' => \SvenJuergens\UrlTransformer\Http\Middleware\Transformer::class,
            'before' => [
                'typo3/cms-frontend/page-resolver',
            ],
            'after' => [
                'typo3/cms-frontend/tsfe',
                'typo3/cms-frontend/authentication',
                'typo3/cms-frontend/static-route-resolver',
            ],
        ],
    ],
];
