<?php 

namespace getmovielist\custom\controller;

use getmovielist\util\Sessao;
use getmovielist\model\AppUser;

class MainContent{
    
    public function mainDeslogado(){
        if(!isset($_GET['page'])){
            
            $controller = new MovieCustomController();
            $controller->main();
            
            return;
        }
        
        switch ($_GET['page']) {
            case 'login':
                $controller = new AppUserCustomController();
                $controller->login();
                break;
            default:
                echo '404';
                break;
        }
    }
    public static function mainLogado(){
        if(!isset($_GET['page'])){
            $controller = new MovieCustomController();
            $controller->main();
            return;
        }
        switch ($_GET['page']) {
            case 'mudar_senha':
                $controller = new AppUserCustomController();
                $usuario = new AppUser();
                $sessao = new Sessao();
                $usuario->setId($sessao->getIdUsuario());
                $controller->editarSenha($usuario);
                break;
            default:
                echo '404';
                break;
                
        }
        
        
    }
    public function main(){
        $sessao = new Sessao();
        if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
            $this->mainDeslogado();
        }else{
            $this->mainLogado();
        }
    }
    
    
}



?>