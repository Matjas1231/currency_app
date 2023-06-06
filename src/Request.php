<?php
declare(strict_types=1);

namespace App;

class Request
{
    private array $get = [];
    private array $post = [];
    private array $server = [];

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
    }

    public function isPost(): bool
    {
       return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function isGet(): bool
    {
       return $this->server['REQUEST_METHOD'] === 'GETS';
    }

    public function hasPostParams(): bool
    {
        return !empty($this->post);
    }

    public function getParam(string $name, $default = null): string | null
    {
        return $this->get[$name] ?? $default;
    }

    public function postParam(string $name, $default = null): string | null
    {
        return $this->post[$name] ?? $default;
    }

    public function allPostParams(): array
    {
        return $this->post;
    }

    public function allGetParams(): array
    {
        return $this->get;
    }
}