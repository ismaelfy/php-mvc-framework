<?php

namespace App\Packages;

class Response
{
    protected $content;
    protected $status;
    protected $headers = [];

    public function __construct($content = '', $status = 200, $headers = [])
    {
        $this->setContent($content);
        $this->setStatus($status);
        $this->setHeaders($headers);
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function send()
    {
        http_response_code($this->getStatus());

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $this->content;
    }

    public function withHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function withJson($data, $status = 200)
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->setStatus($status);
        $this->setContent(json_encode($data));
        return $this;
    }

    public function withRedirect($url, $status = 302)
    {
        $this->headers['Location'] = $url;
        $this->setStatus($status);
        return $this;
    }
}
