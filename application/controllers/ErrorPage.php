<?php

use App\BaseController;

class ErrorPage extends BaseController
{
    protected function allowedMethods()
    {
        return [
            'show' => ['get'],
        ];
    }

    public function show404()
    {
        $this->show(404, "Halaman tidak tersedia.");
    }

    private function show($status, $message)
    {
        set_checkbox($status);
        $this->template->render("error/default", compact("status", "message"));
    }
}