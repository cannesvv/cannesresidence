<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

	public function authenticate(){
        $usuario = Container::getModel('Users');
        $usuario->email = $_POST['email'];
        $usuario->senha = md5($_POST['senha']);

        $usuario->authenticate();
        
        if($usuario->id != null){
            session_start();
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nome'] = $usuario->nome;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['cpf'] = $usuario->cpf;
            $_SESSION['nivel_acesso'] = $usuario->nivel_acesso;
            $_SESSION['telefone'] = $usuario->telefone;
            $_SESSION['data_nascimento'] = $usuario->data_nascimento;
            $_SESSION['genero'] = $usuario->genero;
            $_SESSION['imagem_usuario'] = $usuario->imagem_usuario;
            $_SESSION['apartamentos'] = $usuario->apartamentos($usuario->id);
            if((!isset($_SESSION['apartamento']['id_apartamento'])) && (empty($_SESSION['apartamento']['id_apartamento']))){
                $_SESSION['apartamento'] = $usuario->apartamento($usuario->id);
            }

            
            // echo '<pre>';
            // print_r($_SESSION['apartamento']['id_apartamento']);
            // echo  '</pre>';
            // exit;
            
            header('Location: /dashboard');
        }
        else{
            header('Location: /?login=erro');
        }
    }

    
    public function selecionaApartamento(){
        session_start();
        $_SESSION['apartamento']['id_apartamento'] = $_POST['id_apartamento'];
        //echo '<pre>';
        //print_r($_SESSION['apartamento']['id_apartamento']);
        //echo  '</pre>';
        //exit;

        header('Location: /dashboard');
    }

    public function signOut(){
        session_start();
        session_destroy();
        header('Location: /');
    }

}


?>