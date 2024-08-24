<?php

class CarneGateway
{
    private PDO $conn;
    
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    public function getAll(): array
    {
        $sql = "SELECT *
                FROM carne";
                
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
    
    public function create(array $data): void
    {
        $sql = "INSERT INTO carne (valor_total, qtd_parcelas, data_primeiro_vencimento, periodicidade, valor_entrada)
                VALUES (:valor_total, :qtd_parcelas, :data_primeiro_vencimento, :periodicidade, :valor_entrada)";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":valor_total", $data["valor_total"], PDO::PARAM_STR);
        $stmt->bindValue(":qtd_parcelas", $data["qtd_parcelas"], PDO::PARAM_INT);
        $stmt->bindValue(":data_primeiro_vencimento", $data["data_primeiro_vencimento"], PDO::PARAM_STR);
        $stmt->bindValue(":periodicidade", $data["periodicidade"], PDO::PARAM_STR);
        $stmt->bindValue(":valor_entrada", $data["valor_entrada"], PDO::PARAM_STR);
        
        $stmt->execute();
        
        return;
    }
    
    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM carne
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data;
    }
    
}
