<?php

use Exception\ExceptionHandler;
use Exception\HttpException;
use Routing\Route;
use View\TemplateEngineInterface;

class App
{
    /**
     * @var array
     */
    private $routes = array();

    /**
     * @var TemplateEngineInterface
     */
    private $templateEngine;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var statusCode
     */
    private $statusCode;

    public function __construct(TemplateEngineInterface $templateEngine, $debug = false)
    {
        $this->templateEngine = $templateEngine;
        $this->debug          = $debug;

        $exceptionHandler = new ExceptionHandler($templateEngine, $this->debug);
        set_exception_handler(array($exceptionHandler, 'handle'));
    }

    /**
     * @param string $template
     * @param array  $parameters
     * @param int    $statusCode
     *
     * @return string
     */
    public function render($template, array $parameters = array(), $statusCode = 200)
    {
        $this->statusCode = $statusCode;

        return $this->templateEngine->render($template, $parameters);
    }

    public function run(\Http\Request $request = null)
    {
        if ($request == null) {
            $request = \Http\Request::createFromGlobals();
        }

        $method = $request->getMethod();
        $uri = $request->getUri();

        foreach ($this->routes as $route) {
            if ($route->match($method, $uri)) {
                return $this->process($route, $request);
            }
        }

        throw new HttpException(404, 'Page Not Found');
    }

    /**
     * @param Route $route
     */
    private function process(Route $route, \Http\Request $request, \Http\Response $response = null)
    {
        try {

            $arguments = $route->getArguments();

            array_unshift($arguments, $response);
            array_unshift($arguments, $request);

            if ($response == null) {
                http_response_code($this->statusCode);
                echo call_user_func_array($route->getCallable(), $arguments);

            } else {
                $response->send();
            }

        } catch (HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new HttpException(500, null, $e);
        }
    }

    /**
     * @param string   $method
     * @param string   $pattern
     * @param callable $callable
     */
    private function registerRoute($method, $pattern, $callable)
    {
        $this->routes[] = new Route($method, $pattern, $callable);
    }

    /**
     * @param string $to
     * @param int    $statusCode
     */
    public function redirect($to, $statusCode = 302)
    {
        http_response_code($statusCode);
        header(sprintf('Location: %s', $to));

        exit;
    }

    /**
     * @param string   $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function get($pattern, $callable)
    {
        $this->registerRoute(\Http\Request::GET, $pattern, $callable);

        return $this;
    }

    /**
     * @param string   $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function put($pattern, $callable)
    {
        $this->registerRoute(\Http\Request::PUT, $pattern, $callable);

        return $this;
    }

    /**
     * @param string   $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function post($pattern, $callable)
    {
        $this->registerRoute(\Http\Request::POST, $pattern, $callable);

        return $this;
    }

    /**
     * @param string   $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function delete($pattern, $callable)
    {
        $this->registerRoute(\Http\Request::DELETE, $pattern, $callable);

        return $this;
    }
}
