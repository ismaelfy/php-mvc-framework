<?php

namespace App\Core;

class Request
{
    protected $get;
    protected $post;
    protected $put;
    protected $files;
    protected $headers;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        parse_str(file_get_contents('php://input'), $this->put);
        $this->files = $_FILES;
        $this->headers = $this->getHeaders();
    }

    public function get($key = null)
    {
        if ($key) {
            return $this->get[$key] ?? null;
        }

        return $this->get;
    }

    public function post($key = null)
    {
        if ($key) {
            return $this->post[$key] ?? null;
        }

        return $this->post;
    }

    public function put($key = null)
    {
        if ($key) {
            return $this->put[$key] ?? null;
        }

        return $this->put;
    }

    public function input($key = null)
    {
        return $this->post($key) ?? $this->put($key) ?? $this->get($key);
    }

    public function file($key)
    {
        return $this->files[$key] ?? null;
    }

    public function token()
    {
        return $this->headers['X-CSRF-Token'] ?? null;
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGet()
    {
        return $this->method() === 'GET';
    }

    public function isPost()
    {
        return $this->method() === 'POST';
    }

    public function isPut()
    {
        return $this->method() === 'PUT';
    }

    protected function getHeaders()
    {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $value;
            }
        }

        return $headers;
    }
}
