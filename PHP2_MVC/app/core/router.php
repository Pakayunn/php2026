<?php

class Router
{
    public function disPatch(string $uri): void
    {
        // Lấy path từ URL
        $path = parse_url($uri, PHP_URL_PATH) ?? '';
        $path = trim($path, '/');

        // Loại bỏ base path nếu project nằm trong thư mục con
        $basePath = $this->basePath();
        if ($basePath !== '' && str_starts_with($path, $basePath)) {
            $path = trim(substr($path, strlen($basePath)), '/');
        }

        // Tách URL thành segments
        $segments = $path === '' ? [] : explode('/', $path);

        // Xác định controller
        $controllerSegment = $segments[0] ?? 'home';
        $controllerName = ucfirst($controllerSegment) . 'Controller';

        // Xác định action
        $action = $segments[1] ?? 'index';

        // Các tham số còn lại
        $params = array_slice($segments, 2);

        // Kiểm tra controller tồn tại
        if (!class_exists($controllerName)) {
            $this->notFound("Controller '$controllerName' not exists");
            return;
        }

        $controller = new $controllerName();

        // Kiểm tra method tồn tại
        if (!method_exists($controller, $action)) {
            $this->notFound("Method '$action' not exists");
            return;
        }

        // Gọi controller action
        call_user_func_array([$controller, $action], $params);
    }

    // Lấy base path (trường hợp project nằm trong thư mục con)
    public function basePath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $dir = trim(dirname($scriptName), '/');

        return $dir === '.' ? '' : $dir;
    }

    // Trang 404
    public function notFound(string $message = ''): void
    {
        http_response_code(404);

        echo "
            <div style='text-align:center;margin-top:50px;'>
                <h1 style='color:red;'>404 Not Found</h1>
                <p>$message</p>
                <a href='/' style='color:blue;'>Quay về trang chủ</a>
            </div>
        ";
    }
}