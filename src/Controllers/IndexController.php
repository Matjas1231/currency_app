<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Currency;

class IndexController extends Controller
{
    public function index(): void
    {
        $this->view->render('index', [
            'currencies' => Currency::getAll()
        ]);
    }
}
