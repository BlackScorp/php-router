<?php

final class Request
{
    public function __construct(
        private readonly string $uri,
        private readonly string $method,
        private readonly array  $queryParams
    )
    {

    }

    public static function createFromGlobal(): self
    {
        /** Add # to start of the string to replace only beginning of the URI */
        $scriptName = '#' . $_SERVER['SCRIPT_NAME'];
        $requestUri = '#' . $_SERVER['REQUEST_URI'];
        $baseDir = dirname($scriptName);

        $queryString = $_SERVER['QUERY_STRING'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $queryParams = [];

        parse_str($queryString, $queryParams);

        $url = '/' . str_replace([$scriptName, $baseDir, '?' . $queryString], '', $requestUri);
        $url = str_replace('//', '/', $url);


        return new Request($url, $requestMethod, $queryParams);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function get(string $name, mixed $default = null): mixed
    {
        if (isset($this->queryParams[$name])) {
            return $this->queryParams[$name];
        }
        if (filter_has_var(INPUT_POST, $name)) {
            return filter_input(INPUT_POST, $name);
        }
        return $default;
    }

}