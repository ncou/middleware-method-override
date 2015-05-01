<?php

namespace Phapi\Tests\Middleware\Override;

use Phapi\Middleware\MethodOverride\MethodOverride;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass \Phapi\Middleware\MethodOverride\MethodOverride
 */
class MethodOverrideTest extends TestCase
{

    public function testGetOptions()
    {
        $middleware = new MethodOverride();

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('X-Http-Method-Override')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('X-Http-Method-Override')->andReturn('Options');
        $request->shouldReceive('getMethod')->andReturn('GET');
        $request->shouldReceive('withAttribute')->with('originalRequestMethod', 'GET')->andReturnSelf();
        $request->shouldReceive('withMethod')->with('OPTIONS')->andReturnSelf();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $response = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testPostPut()
    {
        $middleware = new MethodOverride();

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('X-Http-Method-Override')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('X-Http-Method-Override')->andReturn('PUT');
        $request->shouldReceive('getMethod')->andReturn('POST');
        $request->shouldReceive('withAttribute')->with('originalRequestMethod', 'POST')->andReturnSelf();
        $request->shouldReceive('withMethod')->with('PUT')->andReturnSelf();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $response = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testGetPut()
    {
        $middleware = new MethodOverride();

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('X-Http-Method-Override')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('X-Http-Method-Override')->andReturn('PUT');
        $request->shouldReceive('getMethod')->andReturn('GET');
        //$request->shouldReceive('withAttribute')->with('originalRequestMethod', 'POST')->andReturnSelf();
        //$request->shouldReceive('withMethod')->with('PUT')->andReturnSelf();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $response = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testOverrideGetSuccess()
    {
        $middleware = new MethodOverride(['OPTIONS']);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('X-Http-Method-Override')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('X-Http-Method-Override')->andReturn('OPTIONS');
        $request->shouldReceive('getMethod')->andReturn('GET');
        $request->shouldReceive('withAttribute')->with('originalRequestMethod', 'GET')->andReturnSelf();
        $request->shouldReceive('withMethod')->with('OPTIONS')->andReturnSelf();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $response = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testOverrideGetFail()
    {
        $middleware = new MethodOverride(['OPTIONS']);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('X-Http-Method-Override')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('X-Http-Method-Override')->andReturn('HEAD');
        $request->shouldReceive('getMethod')->andReturn('GET');
        //$request->shouldReceive('withAttribute')->with('originalRequestMethod', 'POST')->andReturnSelf();
        //$request->shouldReceive('withMethod')->with('PUT')->andReturnSelf();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $response = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testOverridePostSuccess()
    {
        $middleware = new MethodOverride([], ['PATCH', 'DELETE']);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('X-Http-Method-Override')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('X-Http-Method-Override')->andReturn('PATCH');
        $request->shouldReceive('getMethod')->andReturn('POST');
        $request->shouldReceive('withAttribute')->with('originalRequestMethod', 'POST')->andReturnSelf();
        $request->shouldReceive('withMethod')->with('PATCH')->andReturnSelf();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $response = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testOverridePostFail()
    {
        $middleware = new MethodOverride([], ['PATCH', 'DELETE']);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('X-Http-Method-Override')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('X-Http-Method-Override')->andReturn('PUT');
        $request->shouldReceive('getMethod')->andReturn('POST');
        //$request->shouldReceive('withAttribute')->with('originalRequestMethod', 'POST')->andReturnSelf();
        //$request->shouldReceive('withMethod')->with('PUT')->andReturnSelf();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $response = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }
}
