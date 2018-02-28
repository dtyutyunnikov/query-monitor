<?php

(new class {
    private $config = [];
    private $db = null;

    public function run()
    {
        $this->bootstrap();
        $this->auth();

        echo $this->render('layout.php', $this->handleRequest());
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function render($template, $data = []) : string
    {
        $file = $this->config['views'] . $template;
        if (file_exists($file)) {
            extract($data);

            ob_start();
            include $file;
            $buffer = ob_get_contents();
            ob_end_clean();

            return $buffer;
        } else {
            throw new \RuntimeException('Template not found');
        }
    }

    /**
     * @param string $url
     */
    public function redirect($url)
    {
        header('Location:' . $url, true, 302);
        exit;
    }

    private function bootstrap()
    {
        $this->config = include __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

        try {
            $this->db = new \PDO(
                sprintf(
                    'mysql:host=%s;port=%d;dbname=%s',
                    $this->config['db']['host'],
                    $this->config['db']['port'],
                    $this->config['db']['name']
                ),
                $this->config['db']['user'],
                $this->config['db']['pass'],
                [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                ]
            );
        } catch (\Exception $e) {

        }
    }

    /**
     * @return void
     */
    private function auth()
    {
        if (filter_has_var(INPUT_SERVER, 'HTTP_AUTHORIZATION')
            && $this->config['auth'] === base64_decode(substr(filter_input(INPUT_SERVER, 'HTTP_AUTHORIZATION'), 6))
        ) {
            return;
        }
        header('WWW-Authenticate: Basic realm="app"');
        header('HTTP/1.0 401 Unauthorized', true, 401);
        exit('Access denied');
    }

    /**
     * @return array
     */
    private function handleRequest() : array
    {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD')
            . filter_input(INPUT_SERVER, 'REQUEST_URI');
        $routes = include $this->config['routes'];
        foreach ($routes as $pattern => $callback) {
            if (preg_match('@' . $pattern . '@', $request, $params)) {
                $params[0] = $this;
                return call_user_func_array($callback, array_values($params));
            }
        }
        return call_user_func($routes['GET'], $this);
    }
})->run();
