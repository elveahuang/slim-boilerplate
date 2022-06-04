<?php
declare(strict_types=1);

namespace tests;

use App\Application;
use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\EntityService;
use App\Core\Services\Service;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;
use Throwable;

class TestCase extends PHPUnit_TestCase
{

    protected function getAppInstance(): App
    {
        $bootstrap = new Application();
        return $bootstrap->app;
    }

    /**
     *
     */
    protected function createUri(string $path): Uri
    {
        return new Uri('', '', null, $path);
    }

    /**
     *
     */
    protected function createStream(): StreamInterface
    {
        return (new StreamFactory())->createStream();
    }

    /**
     * 创建请求
     */
    protected function createRequest(
        string $method,
        string $path,
        array  $headers = ['HTTP_ACCEPT' => 'application/json'],
        array  $cookies = [],
        array  $serverParams = []
    ): Request
    {
        $uri = $this->createUri($path);
        $stream = $this->createStream();
        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }
        return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
    }

    /**
     * Post
     */
    protected function post(
        string $path,
        array  $params = [],
        array  $headers = ['HTTP_ACCEPT' => 'application/json'],
        array  $cookies = [],
    ): Response
    {
        $app = $this->getAppInstance();
        $request = $this
            ->createRequest('POST', $path, $headers, $cookies, $params)
            ->withParsedBody($params);
        return $app->handle($request);
    }

    /**
     * Get
     */
    protected function get(
        string $path,
        array  $params = [],
        array  $headers = ['HTTP_ACCEPT' => 'application/json'],
        array  $cookies = [],
    ): Response
    {
        $app = $this->getAppInstance();
        $request = $this
            ->createRequest('GET', $path, $headers, $cookies, $params)
            ->withQueryParams($params);
        return $app->handle($request);
    }

    /**
     * @param Response $response
     * @return bool|string|object
     */
    protected function getJsonBody(Response $response): bool|string|object
    {
        $payload = (string)$response->getBody();
        return json_decode($payload);
    }

    /**
     * @param Response $response
     * @return bool|string|object
     */
    protected function getStringBody(Response $response): bool|string|object
    {
        return (string)$response->getBody();
    }

    /**
     * @param string $id
     * @return EntityService|Service
     * @throws ServiceException
     */
    protected function getService(string $id): EntityService|Service
    {
        try {
            return $this->getAppInstance()->getContainer()->get($id);
        } catch (Throwable $e) {
            throw new ServiceException();
        }
    }

    /**
     * @param string $id
     * @return EntityRepository
     * @throws ServiceException
     */
    protected function getRepository(string $id): EntityRepository
    {
        try {
            return $this->getAppInstance()->getContainer()->get($id);
        } catch (Throwable $e) {
            throw new ServiceException();
        }
    }

}
