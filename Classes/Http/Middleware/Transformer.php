<?php
declare(strict_types = 1);
namespace SvenJuergens\UrlTransformer\Http\Middleware;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Hooks into the frontend request, and checks if a redirect should apply,
 * If so, a redirect response is triggered.
 *
 */
class Transformer implements MiddlewareInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * First hook within the Frontend Request handling
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestPath = urldecode($request->getUri()->getPath());
        $requestPath = mb_strtolower($requestPath, 'UTF-8');
        $requestPath = str_replace(['ä','ü','ö'], ['ae', 'ue', 'oe'], $requestPath);
        if ($requestPath !== $request->getUri()->getPath()) {
            $uri = new Uri(GeneralUtility::locationHeaderUrl($requestPath));
            return $this->buildRedirectResponse($uri);
        }
        return $handler->handle($request);
    }

    /**
     * Creates a PSR-7 compatible Response object
     *
     * @param UriInterface $uri
     * @return ResponseInterface
     */
    protected function buildRedirectResponse(UriInterface $uri): ResponseInterface
    {
        return new RedirectResponse(
            $uri,
            301,
            ['X-Redirect-By' => 'TYPO3 Redirect url transformer']
        );
    }
}
