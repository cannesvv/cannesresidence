<?php

namespace App\Models;
use MF\Model\Model;
use PDO;

class Cars extends Model{

    private $id_veiculo;
    private $fk_id_veiculo;
    private $id_vaga_garagem;
    private $dsc_veiculo;
    private $cor_veiculo;
    private $placa_veiculo;
    private $criado_em;
    private $atualizado_em;


    public function __get($att){
        return $this->$att;
    }

    public function __set($att, $value){
        return $this->$att = $value;
    }

    public function registerCar(){
        $stmt = $this->db->prepare("INSERT INTO veiculo(id_vaga_garagem, dsc_veiculo, cor_veiculo, placa_veiculo) values(:id_vaga_garagem, :dsc_veiculo, :cor_veiculo, :placa_veiculo)");
        $stmt->bindValue(":id_vaga_garagem", $this->id_vaga_garagem);
        $stmt->bindValue(":dsc_veiculo", $this->dsc_veiculo);
        $stmt->bindValue(":cor_veiculo", $this->cor_veiculo);
        $stmt->bindValue(":placa_veiculo", $this->placa_veiculo);
        $stmt->execute();
    }

    public function registerEntry(){
        $stmt = $this->db->prepare("INSERT INTO visitantes(nome, cpf_rg, uf, apartamento, bloco, fk_id_visitante) values(:nome, :cpf_rg, :uf, :apartamento, :bloco, :fk_id_visitante)");
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":cpf_rg", $this->cpf_rg);
        $stmt->bindValue(":uf", $this->uf);
        $stmt->bindValue(":apartamento", $this->apartamento);
        $stmt->bindValue(":bloco", $this->bloco);
        $stmt->bindValue(":fk_id_visitante", $this->fk_id_visitante);
        if($stmt->execute()){
            return true;
        }
    }

    public function registerExit(){
        $stmt = $this->db->prepare("UPDATE visitantes SET data_saida = :data_saida where id_visitante = :id_visitante");
        $stmt->bindValue(":data_saida", $this->data_saida);
        $stmt->bindValue(":id_visitante", $this->id_visitante);
        $stmt->execute();
    }

    public function updateVisitor(){
        $stmt = $this->db->prepare("UPDATE visitantes_cadastrados inner join visitantes on(visitantes_cadastrados.id_visitante = :id_visitante AND visitantes.fk_id_visitante = :id_visitante) SET visitantes_cadastrados.nome = :nome, visitantes_cadastrados.cpf = :cpf, visitantes_cadastrados.rg = :rg, visitantes_cadastrados.uf = :uf, visitantes.nome = :nome, visitantes.cpf_rg = :cpf_rg, visitantes.uf = :uf");
        $stmt->bindValue(":id_visitante", $this->id_visitante);
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":cpf", $this->cpf);
        $stmt->bindValue(":rg", $this->rg);
        $stmt->bindValue(":uf", $this->uf);
        $stmt->bindValue(":cpf_rg", $this->cpf_rg);

        if($stmt->execute()){
            return true;
        }
    }

    public function updateVisitorEntry(){ 
        $stmt = $this->db->prepare("UPDATE visitantes SET apartamento = :apartamento, bloco = :bloco where id_visitante = :id_visitante");;
        $stmt->bindValue(":apartamento", $this->apartamento);
        $stmt->bindValue(":bloco", $this->bloco);
        $stmt->bindValue(":id_visitante", $this->id_visitante); 
        $stmt->execute();
    }

    public function deleteVisitor(){
        $stmt = $this->db->prepare("DELETE from visitantes_cadastrados where id_visitante = :id_visitante");
        $stmt->bindValue(":id_visitante", $this->id_visitante);
        $stmt->execute();
    }

    public function deleteVisitorEntry(){
        $stmt = $this->db->prepare("DELETE from visitantes where id_visitante = :id_visitante");
        $stmt->bindValue(":id_visitante", $this->id_visitante);
        $stmt->execute();
    }

    public function deleteCar(){
        $stmt = $this->db->prepare("DELETE from veiculo where id_veiculo = :id_veiculo");
        $stmt->bindValue(":id_veiculo", $this->id_veiculo);
        $stmt->execute();
    }

    public function getAllVeiculosRegisters($id){ 
        $stmt = $this->db->prepare("SELECT veiculo.*, vaga_garagem.dsc_vaga_garagem FROM veiculo 
        INNER join vaga_garagem on vaga_garagem.id_vaga_garagem = veiculo.id_vaga_garagem 
        INNER join apartamento on apartamento.id_apartamento = vaga_garagem.id_apartamento 
        INNER join usuarios on usuarios.id_usuario = apartamento.id_usuario 
        where apartamento.id_apartamento = ".$_SESSION['apartamento']['id_apartamento'] );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllVeiculosRegistersGeral(){ 
        $stmt = $this->db->prepare("SELECT veiculo.*, vaga_garagem.dsc_vaga_garagem FROM veiculo 
        INNER join vaga_garagem on vaga_garagem.id_vaga_garagem = veiculo.id_vaga_garagem 
        INNER join apartamento on apartamento.id_apartamento = vaga_garagem.id_apartamento 
        INNER join usuarios on usuarios.id_usuario = apartamento.id_usuario");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllVagas($id){ 
        $stmt = $this->db->prepare("SELECT vaga_garagem.* FROM vaga_garagem 
        INNER join apartamento on apartamento.id_apartamento = vaga_garagem.id_apartamento 
        INNER join usuarios on usuarios.id_usuario = apartamento.id_usuario 
        where apartamento.id_apartamento = ".$_SESSION['apartamento']['id_apartamento']);
        //and vaga_garagem.id_vaga_garagem not in (SELECT id_.vaga_garagem FROM vaga_garagem where )"
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllVagaGeral(){ 
        $stmt = $this->db->prepare("SELECT vaga_garagem.* FROM vaga_garagem where id_vaga_garagem not in (select id_vaga_garagem from veiculo)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllVagasDisponivel(){ 
        $stmt = $this->db->prepare("SELECT vaga_garagem.* FROM vaga_garagem 
        INNER join apartamento on apartamento.id_apartamento = vaga_garagem.id_apartamento 
        INNER join usuarios on usuarios.id_usuario = apartamento.id_usuario 
        where apartamento.id_apartamento = ".$_SESSION['apartamento']['id_apartamento']." 
        and vaga_garagem.id_vaga_garagem NOT IN (SELECT vaga_garagem.id_vaga_garagem FROM veiculo inner join vaga_garagem on veiculo.id_vaga_garagem = vaga_garagem.id_vaga_garagem INNER join apartamento on vaga_garagem.id_apartamento = apartamento.id_apartamento where apartamento.id_apartamento = ".$_SESSION['apartamento']['id_apartamento'].")");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCountVagas($id){ 
        $stmt = $this->db->prepare("SELECT count(*) as total_vagas FROM vaga_garagem 
        INNER join apartamento on apartamento.id_apartamento = vaga_garagem.id_apartamento 
        INNER join usuarios on usuarios.id_usuario = apartamento.id_usuario
        where apartamento.id_apartamento = ".$_SESSION['apartamento']['id_apartamento']);
        //$stmt->bindValue(":apartamento.id_usuario", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCountVeiculos($id){ 
        $stmt = $this->db->prepare("SELECT count(*) as total_veiculos FROM veiculo 
        INNER join vaga_garagem on vaga_garagem.id_vaga_garagem = veiculo.id_vaga_garagem 
        INNER join apartamento on apartamento.id_apartamento = vaga_garagem.id_apartamento 
        INNER join usuarios on usuarios.id_usuario = apartamento.id_usuario 
        where apartamento.id_apartamento = ".$_SESSION['apartamento']['id_apartamento'] );
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllRegistersEntry(){ 
        $stmt = $this->db->prepare("SELECT * FROM visitantes ORDER BY data_entrada desc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRegistersEntryFilter(){ 
        $stmt = $this->db->prepare("SELECT * FROM visitantes where DATE(data_entrada) between :data_inicio AND :data_fim ORDER BY data_entrada desc");
        $stmt->bindValue(":data_inicio", $this->data_inicio);
        $stmt->bindValue(":data_fim", $this->data_fim);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectDocumentByCpfRgAndUF(){
        $stmt = $this->db->prepare("SELECT * FROM visitantes_cadastrados where cpf = :cpf OR  rg = :rg AND uf = :uf");
        $stmt->bindValue(":cpf", $this->cpf);
        $stmt->bindValue(":rg", $this->rg);
        $stmt->bindValue(":uf", $this->uf);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function getAllVisitorsByDay(){
        $stmt = $this->db->prepare("SELECT count(*) as visitantes_por_dia FROM visitantes where Date(data_entrada) = :data_atual");
        $stmt->bindValue(":data_atual", $this->data_atual);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllVisitorsByMonth(){
        $stmt = $this->db->prepare("SELECT count(*) as visitantes_por_mes FROM visitantes WHERE MONTH(data_entrada) = MONTH(:data_atual) AND YEAR(data_entrada) = YEAR(:data_atual)");
        $stmt->bindValue(":data_atual", $this->data_atual);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllVisitorsByYear(){
        $stmt = $this->db->prepare("SELECT 
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 01 AND YEAR(data_entrada) = YEAR(:data_atual)) as janeiro,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 02 AND YEAR(data_entrada) = YEAR(:data_atual)) as fevereiro,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 03 AND YEAR(data_entrada) = YEAR(:data_atual)) as marco,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 04 AND YEAR(data_entrada) = YEAR(:data_atual)) as abril,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 05 AND YEAR(data_entrada) = YEAR(:data_atual)) as maio,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 06 AND YEAR(data_entrada) = YEAR(:data_atual)) as junho,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 07 AND YEAR(data_entrada) = YEAR(:data_atual)) as julho,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 08 AND YEAR(data_entrada) = YEAR(:data_atual)) as agosto,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 09 AND YEAR(data_entrada) = YEAR(:data_atual)) as setembro,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 10 AND YEAR(data_entrada) = YEAR(:data_atual)) as outubro,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 11 AND YEAR(data_entrada) = YEAR(:data_atual)) as novembro,
                    (select count(*) FROM visitantes WHERE MONTH(data_entrada) = 12 AND YEAR(data_entrada) = YEAR(:data_atual)) as dezembro
                    from visitantes
                ");
        $stmt->bindValue(":data_atual", $this->data_atual);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllNumberVisitorsPresents(){ //Retorna o número de visitantes que estão com a saída em aberto 
        $stmt = $this->db->prepare("SELECT count(*) as visitantes_presentes FROM visitantes WHERE data_saida is null");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllVisitorsPresents(){ //Retorna os visitantes que estão com a saída em aberto para realizar uma exibição ao usuário
        $stmt = $this->db->prepare("SELECT * FROM visitantes WHERE data_saida is null");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllVisitorsPresentsForCondition(){ //Retorna os visitantes que estão com a saída em aberto, o método é utilizado  para realizar um teste condicional, onde visitantes que não tiveram sua saída registrada não poderão realizar o registro de entrada
        $stmt = $this->db->prepare("SELECT * FROM visitantes WHERE data_saida is null AND cpf_rg = :cpf_rg AND uf = :uf");
        $stmt->bindValue(":cpf_rg", $this->cpf_rg);
        $stmt->bindValue(":uf", $this->uf);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true; // Esse visitante está presente no condomínio, para realizar o registro de entrada primeiro é necessário registrar a saída
        }
    }
}
?>