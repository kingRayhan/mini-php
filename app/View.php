<?php

namespace MiniPHP;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class View
 * @package MiniPHP
 * @author KingRayhan
 */
class View
{
    /**
     * Render twig template
     * @param $templateName
     * @param array $payload
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public static function render($templateName, array $payload = [])
    {
        $baseDir = __DIR__ . '/../';

        $paths = [$baseDir . '/views'];
        if (is_dir($baseDir . '/example/views')) {
            $paths[] = $baseDir . '/example/views';
        }
        $loader = new FilesystemLoader($paths);
        $twig = new Environment($loader, [
            'cache' => $baseDir . '/caches/views',
        ]);
        return $twig->render($templateName . '.twig', $payload);
    }
}