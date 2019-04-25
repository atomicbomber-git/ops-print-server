<?php

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer as PosPrinter;
use App\BaseController;

class Printer extends BaseController
{
    const PRINTER_CONNECTION_TIMEOUT = 2; // In seconds

    protected function allowedMethods()
    {
        return [
            'print' => ['post'],
        ];
    }

    public function print()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }

        $this->validate([
            ["address", "alamat IP printer", "required"],
            ["port", "port printer", "required"],
            ["content", "konten", "required"],
        ]);

        $data = $this->input->post(NULL);

        try {
            $connector = new NetworkPrintConnector(
                $data["address"],
                $data["port"],
                self::PRINTER_CONNECTION_TIMEOUT
            );
        } catch (\Exception $exception) {
            set_status_header(404);
            $this->jsonResponse(["message" => $exception->getMessage()]);
        }

        $printer = new PosPrinter($connector);

        try {
            $printer->text($data["content"]);
        } catch (\Exception $exception) {
            set_status_header(404);
            $this->jsonResponse(["message" => $exception->getMessage()]);
        } finally {
            $printer->close();
        }

        $this->jsonResponse([
            "status" => "success"
        ]);
    }
}
