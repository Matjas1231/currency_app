<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Model;
use App\Request;
use App\View;

abstract class Controller
{
    protected View $view;
    protected Request $request;
    
    public function __construct()
    {
        $this->view = new View();
        $this->request = new Request();
    }

    public static function InitConfiguration(array $config): void
    {
        Model::createConnection($config);
    }

    protected function redirect(string $location, array $message = []): void
    {
        $_SESSION['flash'] = [
            'type' => $message[0],
            'message' => $message[1]
        ];

        header("Location:$location");
        exit;
    }
}