<?php

namespace Phapi\Middleware\MethodOverride;

use Phapi\Contract\Middleware\Middleware;
use Phapi\Exception\MethodNotAllowed;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Method Override Middleware
 *
 * Allow to override the original request method. This is useful when
 * the client aren't able to send other native request methods than
 * GET and POST.
 *
 * It's possible to configure what override methods are allowed when
 * the original request method is GET or POST. By default
 * 'CONNECT', 'TRACE', 'GET', 'HEAD', 'OPTIONS' are allowed to override
 * GET requests and 'PATCH', 'PUT', 'DELETE', 'COPY', 'LOCK', 'UNLOCK'
 * are allowed to override POST requests.
 *
 * @category Phapi
 * @package  Phapi\Middleware\Override
 * @author   Peter Ahinko <peter@ahinko.se>
 * @license  MIT (http://opensource.org/licenses/MIT)
 * @link     https://github.com/phapi/middleware-method-override
 */
class MethodOverride implements Middleware
{

    /**
     * Allowed override methods for original GET request method
     *
     * @var array
     */
    private $getOverride = ['CONNECT', 'TRACE', 'GET', 'HEAD', 'OPTIONS'];

    /**
     * Allowed override methods for original POST request method
     *
     * @var array
     */
    private $postOverride = ['PATCH', 'PUT', 'DELETE', 'COPY', 'LOCK', 'UNLOCK'];

    /**
     * Construct
     *
     * @param array $getOverride Methods allowed to override GET requests
     * @param array $postOverride Methods allowed to override POST requests
     */
    public function __construct($getOverride = [], $postOverride = [])
    {
        // Set methods allowed to override GET requests
        if (!empty($getOverride)) {
            $this->getOverride = $getOverride;
        }

        // Set methods allowed to override POST requests
        if (!empty($postOverride)) {
            $this->postOverride = $postOverride;
        }
    }

    /**
     * Handle the middleware pipeline call
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        // Check if the override header is set
        if ($request->hasHeader('X-Http-Method-Override')) {
            // Get the original request method
            $method = $request->getMethod();
            // Get the override method
            $override = strtoupper($request->getHeaderLine('X-Http-Method-Override'));

            // Check so the override method are allowed based on the original request method
            if (
                ($method === 'GET' && in_array($override, $this->getOverride)) ||
                ($method === 'POST' && in_array($override, $this->postOverride))
            ) {
                // Save current method as attribute
                $request = $request->withAttribute('originalRequestMethod', $method);
                // Set the override method as request method
                $request = $request->withMethod($override);
            } else {
                throw new MethodNotAllowed(
                    'The override method '. $override .' are not allowed to override the original '. $method .' request method.'
                );
            }
        }

        // Call next middleware
        return $next($request, $response, $next);
    }
}
