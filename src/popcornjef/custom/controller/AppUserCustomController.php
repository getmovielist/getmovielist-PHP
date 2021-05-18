<?php
            

namespace popcornjef\custom\controller;





use popcornjef\controller\AppUserController;
use popcornjef\custom\dao\AppUserCustomDAO;
use popcornjef\custom\view\AppUserCustomView;
use popcornjef\model\AppUser;
use popcornjef\util\Sessao;

/**
 * Customize o controller do objeto Usuario aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */



class AppUserCustomController  extends AppUserController {
    

	public function __construct(){
		$this->dao = new AppUserCustomDAO();
		$this->view = new AppUserCustomView();
	}


	public function login(){
	    $this->view->formLogin();
	    
	    if(!isset($_POST['form_login'])){
	        return;
	    }
	    
	    if (! (isset($_POST['login']) && isset ( $_POST['password'] ))) {
	        echo "Incompleto";
	        return;
	    }
	    $usuarioDAO = new AppUserCustomDAO();
	    $usuario = new AppUser();
	    $usuario->setLogin($_POST['login']);
	    
	    $usuario->setPassword(md5($_POST['password']));
	    
	    if($usuarioDAO->autentica($usuario)){
	        
	        $sessao2 = new Sessao();
	        $sessao2->criaSessao($usuario->getId(), $usuario->getLevel(), $usuario->getLogin());
	        echo '<meta http-equiv="refresh" content=0;url="./index.php">';
	        return;
	    }
	    echo 'Errou usuario ou senha';
	}
	public function mainAjax(){
	    
	    $this->cadastrarAjax();
	    
	}
	public function editarSenha(AppUser $usuario)
	{
	    
	    
	    if(!isset($this->post['atualizar_senha'])){
	        $this->view->editarSenha();
	        return;
	    }
	    if (! ( isset ( $this->post ['password'] ) && isset ( $this->post ['senha_confirmada'] ))) {
	        $this->view->editarSenha('Preencha com a mesma senha.');
	        return;
	    }
	    
	    if($this->post['password'] != $this->post['senha_confirmada']){
	        
	        $this->view->editarSenha('As senhas digitadas não correspondem.');
	        return;
	    }
	    if (strlen($this->post ['password']) == 0) {
	        $this->view->editarSenha('Digite uma senha.');
	        return;
	    }
	    if (strlen($this->post ['password']) < 4) {
	        $this->view->editarSenha('Digite uma senha com mais caracteres.');
	        return;
	    }
	    
	    $usuario->setPassword( $this->post ['password'] );
	    
	    if ($this->dao->atualizarSenha($usuario)) {
	        echo "Sucesso";
	    } else {
	        echo "Fracasso";
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?pagina=editar_senha">';
	}
	
	
	
	public function cadastrarAjax() {
	    
	    
	    if(!isset($_POST['form_enviar_usuario'])){
	        return;
	    }
	    
	    
	    if (! ( isset ( $_POST ['name'] ) && isset ( $_POST ['email'] ) && isset ( $_POST ['login'] ) && isset ( $_POST ['password'] ))) {
	        echo ':incompleto';
	        return;
	    }
	    
	    if($_POST['password'] != $_POST['senha_confirmada']){
	        echo ':falha_senhas';
	        return;
	    }
	    
	    
	    $usuario = new AppUser ();
	    $usuario->setName( $_POST ['name'] );
	    $usuario->setEmail ( $_POST ['email'] );
	    $usuario->setLogin ( $_POST ['login'] );
	    $usuario->setPassword( md5($_POST ['password'] ));
	    $usuario->setLevel( Sessao::NIVEL_COMUM );
	    
	        
	    
	    
	    if(count($this->dao->fetchByEmail($usuario)) > 0){
	        echo ':falha_email';
	        return;
	    }
	    if(count($this->dao->fetchByLogin($usuario)) > 0){
	        echo ':falha_login';
	        return;
	    }
	    
	    if ($this->dao->insert( $usuario ))
	    {
	        $id = $this->dao->getConnection()->lastInsertId();
	        echo ':sucesso:'.$id;
	        
	    } else {
	        echo ':falha';
	        return;
	    }
	    
	    $to = $usuario->getEmail();
	    $subject = "GetCrudByID - Seu usuário foi cadastrado com sucesso!";
	    $message = "<p>Bem vindo ao getcrudbyuml! Seu usuário foi cadastrado com sucesso! Aproveite!</p>";
	    $headers = 'MIME-Version: 1.0' . "\r\n";
	    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	    $headers .= 'From: getCrudById <contato@getcrudbyuml.com>';
	    
	    mail($to, $subject, $message, $headers);
	    $sessao = new Sessao();
	    $sessao->criaSessao($id, Sessao::NIVEL_COMUM, $usuario->getLogin());
	}
}
?>