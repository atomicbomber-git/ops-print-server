<?php

use App\BaseController;

class Home extends BaseController
{
    protected function allowedMethods()
    {
        return [
            'print' => ['post'],
        ];
    }

    public function print()
    {
        echo json_encode($this->input->get_post(null)); exit;
    }
}