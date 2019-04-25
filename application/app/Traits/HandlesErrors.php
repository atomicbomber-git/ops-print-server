<?php

namespace App\Traits;

trait HandlesErrors
{
    public function error($status = 500, $message = 'Maaf, terjadi kesalahan. Halaman tidak dapat diakses.')
    {
        set_status_header($status);

        if ($this->input->is_ajax_request()) {
            json_response(["data" => compact('message')]);
        }

        $this->template->render('error/default', compact('status', 'message'));
        exit;
    }

    public function error403()
    {
        $this->error(403, "Maaf, anda tidak diizinkan untuk mengakses halaman ini");
    }

    public function error404()
    {
        $this->error(404, "Maaf, halaman tersebut tidak tersedia.");
    }
}