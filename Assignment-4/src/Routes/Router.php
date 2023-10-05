<?php



namespace App\Routes;

class Router
{
    private static array $list = [];

    public static function get(string $page, \Closure $closure) // GET route
    {
        static::$list[] = [
            'page' => $page,
            'method' => 'GET',
            'logic' => $closure
        ];
    }

    public static function post(string $page, \Closure $closure) // POST route
    {
        static::$list[] = [
            'page' => $page,
            'method' => 'POST',
            'logic' => $closure
        ];
    }

    public static function run()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        $page = trim($_SERVER['REQUEST_URI'], '/');

        foreach (self::$list as $item) {
            if ($item['page'] === $page && $item['method'] === $method) {
                $item['logic']();
                return;
            }
        }
        die('Not found page');
//        $_SESSION['error_message'] = "This user does not exists our records.";
//        header("Location: /");
//        exit();
    }
}