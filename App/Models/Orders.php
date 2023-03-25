<?php

namespace App\Models;
use MF\Model\Model;
use PDO;

class Orders extends Model{

    private $id_encomenda;
    private $empresa;
    private $apartamento;
    private $bloco;
    private $morador;
    private $data_atual;
    private $data_inicio;
    private $data_fim;
    private $status_entrega;

    public function __get($att){
        return $this->$att;
    }

    public function __set($att, $value){
        return $this->$att = $value;
    }

    public function registerOrder(){
        $stmt = $this->db->prepare("INSERT INTO encomendas(empresa, apartamento, bloco, morador, status_entrega) values(:empresa, :apartamento, :bloco, :morador, 'Coletado')");
        $stmt->bindValue(":empresa", $this->empresa);
        $stmt->bindValue(":apartamento", $this->apartamento);
        $stmt->bindValue(":bloco", $this->bloco);
        $stmt->bindValue(":morador", $this->morador);
        $stmt->execute();
    }

    public function updateOrder(){
        $stmt = $this->db->prepare("UPDATE encomendas SET empresa = :empresa, apartamento = :apartamento, bloco = :bloco where id_encomenda = :id_encomenda");
        $stmt->bindValue(":empresa", $this->empresa);
        $stmt->bindValue(":apartamento", $this->apartamento);
        $stmt->bindValue(":bloco", $this->bloco);
        $stmt->bindValue(":id_encomenda", $this->id_encomenda);
        $stmt->execute();
    }

    public function deleteOrder(){
        $stmt = $this->db->prepare("DELETE from encomendas where id_encomenda = :id_encomenda");
        $stmt->bindValue(":id_encomenda", $this->id_encomenda);
        $stmt->execute();
    }

    public function confirmReceipt(){
        $stmt = $this->db->prepare("UPDATE encomendas SET status_entrega = :status_entrega where id_encomenda = :id_encomenda");
        $stmt->bindValue(":status_entrega", $this->status_entrega);
        $stmt->bindValue(":id_encomenda", $this->id_encomenda);
        $stmt->execute();
    }

    public function getAllOrdersRegisters(){
        $stmt = $this->db->prepare("SELECT encomendas.*, apartamento.dsc_apartamento as apartamento, moradores.telefone  FROM encomendas
        inner join apartamento on encomendas.apartamento = apartamento.id_apartamento
        left join moradores on encomendas.morador = moradores.id_morador");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllMoradoresRegisters(){
        $stmt = $this->db->prepare("SELECT *  FROM moradores");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrdersRegistersInUser(){
        $stmt = $this->db->prepare("SELECT encomendas.*, apartamento.dsc_apartamento as apartamento  FROM encomendas
        inner join apartamento on encomendas.apartamento = apartamento.id_apartamento
        inner join usuarios on apartamento.id_usuario = usuarios.id_usuario
        where usuarios.id_usuario = ".$_SESSION['id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRegistersFilter(){ 
        $stmt = $this->db->prepare("SELECT * FROM encomendas where DATE(data_entrega) between :data_inicio AND :data_fim ORDER BY data_entrega desc");
        $stmt->bindValue(":data_inicio", $this->data_inicio);
        $stmt->bindValue(":data_fim", $this->data_fim);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrdersByDay(){
        $stmt = $this->db->prepare("SELECT count(*) as encomendas_por_dia FROM encomendas where Date(data_entrega) = :data_atual");
        $stmt->bindValue(":data_atual", $this->data_atual);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllOrdersByMonth(){
        $stmt = $this->db->prepare("SELECT count(*) as encomendas_por_mes FROM encomendas WHERE MONTH(data_entrega) = MONTH(:data_atual) AND YEAR(data_entrega) = YEAR(:data_atual)");
        $stmt->bindValue(":data_atual", $this->data_atual);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllOrdersByYear(){
        $stmt = $this->db->prepare("SELECT 
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 01 AND YEAR(data_entrega) = YEAR(:data_atual)) as janeiro,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 02 AND YEAR(data_entrega) = YEAR(:data_atual)) as fevereiro,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 03 AND YEAR(data_entrega) = YEAR(:data_atual)) as marco,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 04 AND YEAR(data_entrega) = YEAR(:data_atual)) as abril,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 05 AND YEAR(data_entrega) = YEAR(:data_atual)) as maio,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 06 AND YEAR(data_entrega) = YEAR(:data_atual)) as junho,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 07 AND YEAR(data_entrega) = YEAR(:data_atual)) as julho,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 08 AND YEAR(data_entrega) = YEAR(:data_atual)) as agosto,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 09 AND YEAR(data_entrega) = YEAR(:data_atual)) as setembro,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 10 AND YEAR(data_entrega) = YEAR(:data_atual)) as outubro,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 11 AND YEAR(data_entrega) = YEAR(:data_atual)) as novembro,
                    (select count(*) FROM encomendas WHERE MONTH(data_entrega) = 12 AND YEAR(data_entrega) = YEAR(:data_atual)) as dezembro
                    from encomendas
                ");
        $stmt->bindValue(":data_atual", $this->data_atual);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllApartamentos(){
        $stmt = $this->db->prepare("SELECT * FROM apartamento");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllApartamentosRegisters(){
        $stmt = $this->db->prepare("SELECT * FROM apartamento where id_usuario = " .$_SESSION['id']." and id_apartamento = ".$_SESSION['apartamento']['id_apartamento']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>