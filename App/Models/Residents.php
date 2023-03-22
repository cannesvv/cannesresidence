<?php

namespace App\Models;
use MF\Model\Model;
use PDO;

class Residents extends Model{

    private $id_morador;
    private $nome;
    private $cpf;
    private $telefone;
    private $apartamento;
    private $bloco;

    public function __get($att){
        return $this->$att;
    }

    public function __set($att, $value){
        return $this->$att = $value;
    }

    public function registerResident(){
        $stmt = $this->db->prepare("INSERT INTO moradores(nome, cpf, telefone, id_apartamento) values(:nome, :cpf, :telefone, :id_apartamento)");
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":cpf", $this->cpf);
        $stmt->bindValue(":telefone", $this->telefone);
        $stmt->bindValue(":id_apartamento", $this->id_apartamento);
        // $stmt->bindValue(":bloco", $this->bloco);
        $stmt->execute();
    }

    public function updateResident(){
        $stmt = $this->db->prepare("UPDATE moradores SET nome = :nome, cpf = :cpf, telefone = :telefone, id_apartamento = :id_apartamento where id_morador = :id_morador");
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":cpf", $this->cpf);
        $stmt->bindValue(":telefone", $this->telefone);
        $stmt->bindValue(":id_apartamento", $this->id_apartamento);
        // $stmt->bindValue(":bloco", $this->bloco);
        $stmt->bindValue(":id_morador", $this->id_morador);
        $stmt->execute();
    }

    public function deleteResident(){
        $stmt = $this->db->prepare("DELETE from moradores where id_morador = :id_morador");
        $stmt->bindValue(":id_morador", $this->id_morador);
        $stmt->execute();
    }

    public function getAllResidentsRegisters(){
        $stmt = $this->db->prepare("SELECT moradores.*, apartamento.dsc_apartamento as dsc_apartamento FROM moradores
        inner join apartamento on moradores.id_apartamento = apartamento.id_apartamento");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllApartamentosRegisters(){
        $stmt = $this->db->prepare("SELECT * FROM apartamento where id_usuario = " .$_SESSION['id']." and id_apartamento = ".$_SESSION['apartamento']['id_apartamento']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllResidentsRegistersCondomino(){
        $stmt = $this->db->prepare("SELECT moradores.*, apartamento.dsc_apartamento  FROM moradores 
        inner join apartamento on moradores.id_apartamento = apartamento.id_apartamento
        where apartamento.id_usuario = " .$_SESSION['id']." and moradores.id_apartamento = ".$_SESSION['apartamento']['id_apartamento']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllApartamentos(){
        $stmt = $this->db->prepare("SELECT * FROM apartamento");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}



?>