<?php

// use Jenssegers\Blade\Blade;

// class Controller
// {
//     public function view(string $view, array $data = []): void
//     {
//         $normalizedView = $this->normalizeViewName($view);
//         $viewPath = str_replace('.', '/', $normalizedView);

//         $candidates = [
//             Views_PATH . '/' . $viewPath . '.blade.php',
//             Views_PATH . '/' . $viewPath . '.blade',
//         ];

//         $found = null;
//         foreach ($candidates as $file) {
//             if (is_file($file)) {
//                 $found = $file;
//                 break;
//             }
//         }

//         if (!$found) {
//             throw new RuntimeException("Blade view not found: {$view} (resolved: {$viewPath})");
//         }

//         $cachePath = BASE_PATH . '/storage/cache';
//         if (!is_dir($cachePath) && !mkdir($cachePath, 0775, true) && !is_dir($cachePath)) {
//             throw new RuntimeException("Cannot create cache directory: {$cachePath}");
//         }

//         $blade = new Blade(Views_PATH, $cachePath);
//         echo $blade->render($normalizedView, $data);
//     }

//     protected function normalizeViewName(string $view): string
//     {
//         $view = trim($view);
//         $view = str_replace(['\\', '/'], '.', $view);
//         $view = preg_replace('/\.+/', '.', $view);
//         return trim($view, '.');
//     }

//     public function model($name)
//     {
//         $class = ucfirst($name);
//         if (!class_exists($class)) {
//             throw new Exception("Model class not found: {$class}");
//         }
//         return new $class();
//     }

//     /**
//      * Redirect — dùng dirname(SCRIPT_NAME) giống Router.basePath()
//      * .htaccess rewrite set SCRIPT_NAME = /Php2/PHP2_MVC/app/Public/index.php
//      * base = /Php2/PHP2_MVC/app/Public
//      * target = /Php2/PHP2_MVC/app/Public/product
//      */
//     public function redirect($path)
//     {
//         $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
//         $base = rtrim(dirname($scriptName), '/');

//         $target = $base . '/' . ltrim($path, '/');
//         header('Location: ' . $target);
//         exit;
//     }

//     protected function baseUrl()
//     {
//         $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
//         return rtrim(dirname($scriptName), '/');
//     }

//     public function notFound($message): void
//     {
//         http_response_code(404);
//         echo "<h1>Controller Not Found - {$message}</h1>";
//     }
// }

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
     */
    public function redirect($path)
    {
        // Lấy protocol (http hoặc https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        
        // Lấy host
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        
        // Lấy base path từ SCRIPT_NAME
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        $base = rtrim(dirname($scriptName), '/');
        
        // Tạo URL tuyệt đối
        $url = $protocol . '://' . $host . $base . '/' . ltrim($path, '/');
        
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