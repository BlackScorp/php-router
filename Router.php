<?php
require_once __DIR__ . '/RouteNotFoundException.php';

final class Router
{
    private array $routes = [];
    private const SEPARATOR = '::';
    public function register(string $url, callable $action,string $methods = 'GET|POST'): array
    {
        $url = preg_replace('~{(.*)}~mU', '(?<$1>\S+)', $url);
        $url = sprintf('~^(%s)/?%s(%s)$~i',$url, self::SEPARATOR, $methods);
        $this->routes[$url]= $action;

        return $this->routes;
    }
    public function handle(Request $request): mixed
    {
        $searchString = $request->getUri() . self::SEPARATOR .$request->getMethod();

        foreach($this->routes as $rexEx => $action){
            $matches = [];
            if(!preg_match($rexEx,$searchString,$matches)){
                continue;
            }
            $matches = array_filter($matches,function ($key){
                return is_int($key) === false;
            }, ARRAY_FILTER_USE_KEY);

            $matches['request'] = $request;

            return $action(...$matches);
        }
        $message = sprintf('Route %s not found',$request->getUri());
        http_response_code(404);
        throw new RouteNotFoundException($message);
    }
}