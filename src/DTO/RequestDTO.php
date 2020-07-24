<?php

namespace App\DTO;

class RequestDTO
{
    private string $baseUrl;

    private string $url;

    private string $method;

    private ?array $fields;

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param array|null $fields
     */
    public function setFields(?array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return array|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }
}
