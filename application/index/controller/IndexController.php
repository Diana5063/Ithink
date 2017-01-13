<?php
namespace app\index\controller;

class IndexController
{
    public function indexAction()
    {
        return 'Hello World ' . date('Y-m-d H:i:s');
    }

    public function showAction()
    {
        return json_encode(['name' => 'Diana', 'City' => 'wuhan']);
    }
}
