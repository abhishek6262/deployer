<?php

namespace Deployer\Response;

/**
 * Class Template
 * @package Deployer\Response
 */
final class Template
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $variables;

    /**
     * Template constructor.
     *
     * @param string $path
     * @param array $variables
     *
     * @throws \Exception
     */
    public function __construct(string $path, array $variables = [])
    {
        if (! file_exists($path)) {
            throw new \Exception("Failed to find the template at path: '$path'");
        }

        $this->path = $path;
        $this->variables = $variables;
    }

    /**
     * Returns the content from the template.
     *
     * @return string
     */
    public function content(): string
    {
        extract($this->variables);

        ob_start();
            require_once $this->path;
            $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
