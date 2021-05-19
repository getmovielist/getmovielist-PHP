<?php
            
/**
 * Customize o controller do objeto Subtitle aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\SubtitleController;
use getmovielist\custom\dao\SubtitleCustomDAO;
use getmovielist\custom\view\SubtitleCustomView;
use getmovielist\model\Movie;
use getmovielist\model\Subtitle;
use getmovielist\dao\MovieDAO;
use getmovielist\util\Sessao;

class SubtitleCustomController  extends SubtitleController {
    

	public function __construct(){
		$this->dao = new SubtitleCustomDAO();
		$this->view = new SubtitleCustomView();
	}


	public function mainAdm(Movie $movie){
	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() != Sessao::NIVEL_ADM){
	        return;
	    }
	    echo '<button class="float-right btn ml-3 btn-outline-light btn-circle btn-lg text-white" data-bs-toggle="modal" data-bs-target="#modalAddSubtitle"><i class="fa fa-stack-exchange icone-maior"></i></button>';
	    $this->view->showInsertForm2($movie);
	    $this->add();
	    
	}
	
	public function add(){
	    if(!isset($_POST['enviar_subtitle'])){
	        return;
	    }
	    if (! ( isset ( $_POST ['label'] ) && isset ( $_POST ['file_path'] ) &&  isset($_POST ['movie']))) {
	        echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing.
                </div>
	            
                ';
	        return;
	    }
	    $subtitle = new Subtitle();
	    $subtitle->setLabel ( $_POST ['label'] );
	    $subtitle->setFilePath ( $_POST ['file_path'] );
	    $subtitle->getMovie()->setId ( $_POST ['movie'] );
	    
	    if ($this->dao->insert ($subtitle ))
	    {
	        echo '
	            
<div class="alert alert-success" role="alert">
  Sucesso ao inserir Subtitle
</div>
	            
';
	    } else {
	        echo '
	            
<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Subtitle
</div>
	            
';
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=.">';
	    
	}
}
?>