<?php

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer as PosPrinter;
use App\BaseController;

class Printer extends BaseController
{
    const PRINTER_CONNECTION_TIMEOUT = 2; // In seconds

    public function __construct()
    {
        parent::__construct();

        $this->handleCorsRequest();
    }

    protected function allowedMethods()
    {
        return [
            'print' => ['post'],
            'manual_print' => ['post'],
        ];
    }

    private function handleCorsRequest()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function manual_print()
    {
        $data = $this->input->post(NULL);

        foreach ($data["commands"] as $key => $command) {
            if (isset($command["arguments"])) {
                $data["commands"][$key]["arguments"] = array_map(function ($argument) {

                    $argument["type"] = $argument["type"] ?? false;

                    switch ($argument["type"]) {
                        case "integer":
                            $data = (int) $argument["data"];
                            break;
                        case "float":
                            $data = (int) $argument["data"];
                            break;
                        default:
                            $data = $argument["data"];
                    }
                    return $data;
                }, $command["arguments"]);
            }
            else {
                $data["commands"][$key]["arguments"] = [];
            }
        }
        
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
            foreach ($data["commands"] as $command) {
                method_exists($printer, $command["name"]) &&
                    $printer->{$command["name"]}(...$command["arguments"]);
            }
        } catch (\Exception $exception) {
            set_status_header(404);
            $this->jsonResponse(["message" => $exception->getMessage()]);
        } finally {
            $printer->close();
        }

    }

    public function print()
    {
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
            // $printer->setTextSize(8, 8);
            $printer->text($data["content"]);
            $printer->cut();
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
