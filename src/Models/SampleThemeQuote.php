<?php

namespace Scm\PluginSampleTheming\Models;

class SampleThemeQuote {
    protected ?string $_id = null;
    protected ?string $content = null;
    protected ?string $author = null;
    protected ?string $error = null;


    public function __construct(object $what) {
        foreach ($this as $key => $val) {
            $this->$key = null;
            if (property_exists($what,$key) ) {
                $this->$key = $what->$key;
            }
        }
    }

    public function getId(): ?string
    {
        return $this->_id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getError(): ?string
    {
        return $this->error;
    }



}
