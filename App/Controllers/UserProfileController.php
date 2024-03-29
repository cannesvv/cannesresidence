<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class UserProfileController extends Action {

    public function validateAuthentication(){
        session_start();
        if(!isset($_SESSION['id']) || $_SESSION['id'] == null){
            header('Location: /?login=erro');
        }
    }

	public function myProfile(){
        $this->validateAuthentication();    
        
        // Formatando exibição do campo Data de nascimento 
        $data_nascimento = str_replace("/", "-", $_SESSION['data_nascimento']);
        $_SESSION['data_nascimento'] = date('d/m/Y', strtotime($data_nascimento));

        $this->render('my_profile');
    }
    
    public function listProfile(){
        $this->validateAuthentication();
        if(($_SESSION['nivel_acesso'] == 'administrador') || ($_SESSION['nivel_acesso'] == 'porteiro')){
            $usuario = Container::getModel('Users');
            $this->view->usuarios = $usuario->getAllUsuarios();   
            $this->render('all_user');
            
        }
    }

    public function updateUser(){
        $this->validateAuthentication();
        $usuario = Container::getModel('Users');
        
        $coluna = '';
        $valor = '';
        $msg = '';

        if (isset($_POST['nome']) && strlen($_POST['nome']) >= 3){
            $coluna = 'nome';
            $valor = $_POST['nome'];
            //$msg = 'Nome atualizado com sucesso!';
            if($coluna != '' && $valor != ''){
                $usuario->updateUser($coluna, $valor, $_POST['id_usuario']);
                //echo "<script>alert('$msg')</script>";
            } 
        }else{
            echo "<script>alert('Erro ao atualizar dados!')</script>";
        }
        // else if(isset($_POST['data_nascimento']) && strlen($_POST['data_nascimento']) == 10){
        //     $coluna = 'data_nascimento';
        //     $data_nascimento = str_replace("/", "-", $_POST['data_nascimento']);
        //     $valor = date('Y-m-d', strtotime($data_nascimento));
        //     $msg = 'Data de nascimento atualizada com sucesso!';
        // }
        // else if(isset($_POST['genero']) && $_POST['genero'] != ''){
        //     $coluna = 'genero';
        //     $valor = $_POST['genero'];
        //     $msg = 'Gênero atualizado com sucesso!';
        // }
        if(isset($_POST['telefone']) && strlen($_POST['telefone']) >= 14){
            $coluna = 'telefone';
            $valor = $_POST['telefone'];
            //$msg = 'Telefone atualizado com sucesso!';
            if($coluna != '' && $valor != ''){
                $usuario->updateUser($coluna, $valor, $_POST['id_usuario']);
                //echo "<script>alert('$msg')</script>";
            } 
        }else{
            echo "<script>alert('Erro ao atualizar dados!')</script>";
        }

        if(isset($_POST['cpf']) && strlen($_POST['cpf']) >= 14){
            $coluna = 'cpf';
            $valor = $_POST['cpf'];
            //$msg = 'CPF/CNPJ atualizado com sucesso!';
            if($coluna != '' && $valor != ''){
                $usuario->updateUser($coluna, $valor, $_POST['id_usuario']);
                //echo "<script>alert('$msg')</script>";
            } 
        }else{
            echo "<script>alert('Erro ao atualizar dados!')</script>";
        }

        if(isset($_POST['email']) && strlen($_POST['email']) >= 5){
            $coluna = 'email';
            $valor = $_POST['email'];
            //$msg = 'Email atualizado com sucesso!';
            if($coluna != '' && $valor != ''){
                $usuario->updateUser($coluna, $valor, $_POST['id_usuario']);
                //echo "<script>alert('$msg')</script>";
            } 
        } else{
            echo "<script>alert('Erro ao atualizar dados!')</script>";
        }
        // else if(isset($_FILES['imagem']) && $_FILES['imagem'] != ''){
        //     $coluna = 'imagem_usuario';
        //     $extensao = strtolower(substr($_FILES['imagem']['name'], -4));
        //     $valor = md5(time()) . $extensao;
        //     move_uploaded_file($_FILES['imagem']['tmp_name'], "img/users/$valor");
        //     $msg = 'Imagem atualizada com sucesso!';
        // }
        
        echo "<script>alert('Dados atualizados com sucesso!')</script>";
        

        //if($coluna != '' && $valor != '' && $msg != ''){
        //    $usuario->updateProfile($coluna, $valor, $_POST['id_usuario']);
        //    echo "<script>alert('$msg')</script>";
        //}        
        
        echo "<script>location.href = '/user' </script>";
    }

    public function updateProfile(){
        $usuario = Container::getModel('Users');
        
        $coluna = '';
        $valor = '';
        $msg = '';

        if (isset($_POST['nome']) && strlen($_POST['nome']) >= 3){
            $coluna = 'nome';
            $valor = $_POST['nome'];
            $msg = 'Nome atualizado com sucesso!';
        }
        else if(isset($_POST['senha']) && $_POST['senha'] != ''){
            $coluna = 'senha';
            $valor = md5($_POST['senha']);
            $msg = 'Senha Atualizada com sucesso!';
        }
        else if(isset($_POST['data_nascimento']) && strlen($_POST['data_nascimento']) == 10){
            $coluna = 'data_nascimento';
            $data_nascimento = str_replace("/", "-", $_POST['data_nascimento']);
            $valor = date('Y-m-d', strtotime($data_nascimento));
            $msg = 'Data de nascimento atualizada com sucesso!';
        }
        else if(isset($_POST['genero']) && $_POST['genero'] != ''){
            $coluna = 'genero';
            $valor = $_POST['genero'];
            $msg = 'Gênero atualizado com sucesso!';
        }
        else if(isset($_POST['telefone']) && strlen($_POST['telefone']) >= 14){
            $coluna = 'telefone';
            $valor = $_POST['telefone'];
            $msg = 'Telefone atualizado com sucesso!';
        }
        else if(isset($_FILES['imagem']) && $_FILES['imagem'] != ''){
            $coluna = 'imagem_usuario';
            $extensao = strtolower(substr($_FILES['imagem']['name'], -4));
            $valor = md5(time()) . $extensao;
            move_uploaded_file($_FILES['imagem']['tmp_name'], "img/users/$valor");
            $msg = 'Imagem atualizada com sucesso!';
        }
        else{
            echo "<script>alert('Erro ao atualizar dados!')</script>";
        }

        if($coluna != '' && $valor != '' && $msg != ''){
            $usuario->updateProfile($coluna, $valor, $_POST['id_usuario']);
            echo "<script>alert('$msg')</script>";
        }        
        
        echo "<script>location.href = '/my_profile' </script>";
    }

}

?>