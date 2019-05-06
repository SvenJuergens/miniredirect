<?php

/**
 * Definitions for middlewares provided by EXT:miniredirect
 */
return [
    'frontend' => [
        'svenjuergens/miniredirect' => [
            'target' => \SvenJuergens\Miniredirect\Http\Middleware\MiniRedirect::class,
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
