<?php
            
/**
 * Customize o controller do objeto MovieFile aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\MovieFileController;
use getmovielist\custom\dao\MovieFileCustomDAO;
use getmovielist\custom\view\MovieFileCustomView;
use getmovielist\model\Movie;
use getmovielist\model\MovieFile;

class MovieFileCustomController  extends MovieFileController {
    

	public function __construct(){
		$this->dao = new MovieFileCustomDAO();
		$this->view = new MovieFileCustomView();
	}


	
	public function addFile(Movie $movie){
	    if(!isset($_POST['enviar_movie_file']))
	    {
	        $this->view->showInsertForm2($movie);
	        return;
	    }
	    if (! ( isset ( $_POST ['file_path'] ) &&  isset($_POST ['movie']))) {
	        echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing.
                </div>
	            
                ';
	        return;
	    }
	    $movieFile = new MovieFile();
	    $movieFile->setFilePath ( $_POST ['file_path'] );
	    $movieFile->getMovie()->setId ( $_POST ['movie'] );
	    
	    if ($this->dao->insert ($movieFile ))
	    {
	        echo '
	            
<div class="alert alert-success" role="alert">
  Sucesso ao inserir Movie File
</div>
	            
';
	    } else {
	        echo '
	            
<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Movie File
</div>
	            
';
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=movie_file">';
	}
}
?>