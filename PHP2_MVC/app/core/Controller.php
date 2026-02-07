<?php

use Jenssegers\Blade\Blade;

class Controller
{
    public function view(string $view, array $data = []): void
    {
        $normalizedView = $this->normalizeViewName($view);
        $viewPath = str_replace('.', '/', $normalizedView);

        $candidates = [
            Views_PATH . '/' . $viewPath . '.blade.php',
            Views_PATH . '/' . $viewPath . '.blade',
        ];

        $found = null;
        foreach ($candidates as $file) {
            if (is_file($file)) {
                $found = $file;
                break;
            }
        }

        if (!$found) {
            throw new RuntimeException("Blade view not found: {$view} (resolved: {$viewPath})");
        }

        $cachePath = BASE_PATH . '/storage/cache';
        if (!is_dir($cachePath) && !mkdir($cachePath, 0775, true) && !is_dir($cachePath)) {
            throw new RuntimeException("Cannot create cache directory: {$cachePath}");
        }

        $blade = new Blade(Views_PATH, $cachePath);
        echo $blade->render($normalizedView, $data);
    }

    protected function normalizeViewName(string $view): string
    {
        $view = trim($view);
        $view = str_replace(['\\', '/'], '.', $view);
        $view = preg_replace('/\.+/', '.', $view);
        return trim($view, '.');
    }

    public function model($name)
    {
        $class = ucfirst($name);
        if (!class_exists($class)) {
            throw new Exception("Model class not found: {$class}");
        }
        return new $class();
    }

    /**
     * Redirect với URL tuyệt đối
     * Sử dụng protocol + host + base path để tạo URL đầy đủ
     */public function redirect($path)
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
        ? 'https' : 'http';

    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $base = rtrim(dirname($scriptName), '/');

    // Xử lý không cho tạo ///
    $path = '/' . ltrim($path, '/');

    $url = $protocol . '://' . $host;

    if ($base !== '') {
        $url .= '/' . trim($base, '/');
    }

    $url .= $path;

    header('Location: ' . $url);
    exit;
}


    protected function baseUrl()
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        return rtrim(dirname($scriptName), '/');
    }

    public function notFound($message): void
    {
        http_response_code(404);
        echo "<h1>Controller Not Found - {$message}</h1>";
    }
}