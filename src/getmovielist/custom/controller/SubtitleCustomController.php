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
use getmovielist\dao\MovieFileDAO;
use getmovielist\model\MovieFile;

class SubtitleCustomController  extends SubtitleController {
    

	public function __construct(){
		$this->dao = new SubtitleCustomDAO();
		$this->view = new SubtitleCustomView();
	}


	public function addSubtitle(Movie $movie){
	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() != Sessao::NIVEL_ADM){
	        return;
	    }
	    if(!isset($_POST['enviar_subtitle'])){
	        $movieFile = new MovieFile();
	        $movieFile->getMovie()->setId($movie->getId());
	        $movieFileDao = new MovieFileDAO($this->dao->getConnection());
	        $listMovieFile = $movieFileDao->fetchByMovie($movieFile);
	        if(count($listMovieFile) == 0){
	            return;
	        }
	        $this->view->showInsertForm($listMovieFile);
	        return;
	    }



	    if (! ( isset ( $_POST ['label'] ) && isset ( $_POST ['file_path'] ) && isset ( $_POST ['lang'] ) &&  isset($_POST ['movie_file']))) {
	        echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing.
                </div>
	            
                ';
	        return;
	    }
	    $subtitle = new Subtitle ();
	    $subtitle->setLabel ( $_POST ['label'] );
	    $subtitle->setFilePath ( $_POST ['file_path'] );
	    $subtitle->setLang ( $_POST ['lang'] );
	    $subtitle->getMovieFile()->setId ( $_POST ['movie_file'] );
	    
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
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=?id='.$_GET['id'].'">';
	}
	public function addNovoVelho(){
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