<?php



namespace App\WEB\Routes;

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
        $explodePage = explode('?',$page);

//        var_dump($explodePage);


        foreach (self::$list as $item) {
            if ($item['page'] === $explodePage[0] && $item['method'] === $method) {
                $item['logic']();
                return;
            }
        }
        die('404 Not found page');
    }
}
