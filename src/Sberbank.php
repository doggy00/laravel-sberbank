<?php


namespace SberbankApi;


class Sberbank
{
    public static function create(array $content = []): self
    {
        return new self($content);
    }

    public function __construct(array $content = [])
    {
        $this->content($content);
    }

    public function content(array $content): self
    {
        $this->params = $content;

        return $this;
    }
}