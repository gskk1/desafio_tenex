<?php

class CarneController
{
    public function __construct(private CarneGateway $gateway)
    {
    }
    
    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            
            $this->processResourceRequest($method, $id);
            
        } else {
            
            $this->processCollectionRequest($method);
            
        }
    }
    
    private function processResourceRequest(string $method, string $id): void
    {
        $result = $this->gateway->get($id);
        
        if ( ! $result) {
            http_response_code(404);
            echo json_encode(["message" => "Carne não encontrado"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($result);
                break;
                
            default:
                http_response_code(405);
                header("Allow: GET");
        }
    }
    
    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;
                
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                
                $errors = $this->getValidationErrors($data);
                
                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["erros" => $errors]);
                    break;
                }
                
                if (empty($data["valor_entrada"])) {
                    $data['valor_entrada'] = 0;
                }

                $carne = [];
                $carne["total"] = $data["valor_total"];
                $dataobject = DateTime::createFromFormat('Y-m-d', $data["data_primeiro_vencimento"]);
                $i = 1;
                $qtd_parcelas = $data["qtd_parcelas"];
                
                if ( ($data["valor_entrada"] != 0)) {	
                    $parcela = [];
                    $parcela["valor"] = $data["valor_entrada"];
                    $parcela["numero"] = $i;
                    $parcela["entrada"] = true;
                    $carne["parcelas"][$i] = $parcela;
                    $i++;
                    $qtd_parcelas--;
                }
                
                if ($qtd_parcelas != 0) {
                    $valorparcela = ($carne["total"] - $data["valor_entrada"])/$qtd_parcelas;
                    for ($i; $i <= $data["qtd_parcelas"] ; $i++) {
                        $parcela = [];
                        $parcela["data_vencimento"] = $dataobject->format('Y-m-d');
                        $parcela["valor"] = $valorparcela;
                        $parcela["numero"] = $i;
        
                        if ($data["periodicidade"] == "mensal")            
                            $dataobject->modify('+1 month');
                        else if ($data["periodicidade"] == "semanal")
                            $dataobject->modify("+1 week");
        
                        $carne["parcelas"][$i] = $parcela;
                    }
                }

                $this->gateway->create($data);
                
                http_response_code(201);
                echo json_encode($carne);

                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
    
    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];
        
        if ($is_new && empty($data["valor_total"])) {
            $errors[] = "valor_total não pode ser nulo";
        }
        
        if ($is_new && empty($data["qtd_parcelas"])) {
            $errors[] = "qtd_parcelas não pode ser nulo";
        }
        
        if ($is_new && (($data["periodicidade"]) != "mensal" && ($data["periodicidade"]) != "semanal" )) {
            $errors[] = "Campo periodicidade deve ter valor 'mensal' ou 'semanal'";
        }
        
        if (array_key_exists("size", $data)) {
            if (filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "size must be an integer";
            }
        }
        
        return $errors;
    }
}









