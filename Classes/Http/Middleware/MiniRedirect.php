<?php
declare(strict_types = 1);
namespace SvenJuergens\Miniredirect\Http\Middleware;

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
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Hooks into the frontend request, and checks if a redirect should apply,
 * If so, a redirect response is triggered.
 *
 */
class MiniRedirect implements MiddlewareInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * First hook within the Frontend Request handling
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // don't handle spaces in path
        if(strpos($request->getUri()->getPath(), '%20') !== false){
            return $handler->handle($request);
        }
        $originalRequestPath = urldecode($request->getUri()->getPath());
        $requestPath = mb_strtolower($originalRequestPath, 'UTF-8');
        $requestPath = str_replace(['ä','ü','ö','ß'], ['ae', 'ue', 'oe', 'ss'], $requestPath);
        if ($requestPath !== $request->getUri()->getPath()) {
            $uri = new Uri(GeneralUtility::locationHeaderUrl($requestPath));
            if((bool)GeneralUtility::makeInstance(ExtensionConfiguration::class)
                ->get('miniredirect', 'useLogging')
            ){
                $this->logger->info('miniredirect', [
                    'originalRequestPath' => $request->getUri()->getHost() . htmlspecialchars($originalRequestPath),
                    'uri' => $uri->getPath(),
                    'referrer' => $request->getServerParams()['HTTP_REFERER'] ?? ''
                ]);
            }
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
            ['X-Redirect-By' => 'TYPO3 Redirect by Miniredirect']
        );
    }
}
