<?php
            
/**
 * Customize o controller do objeto TorrentMovie aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\TorrentMovieController;
use getmovielist\custom\dao\TorrentMovieCustomDAO;
use getmovielist\custom\view\TorrentMovieCustomView;
use getmovielist\model\Movie;
use getmovielist\dao\MovieFileDAO;
use getmovielist\model\TorrentMovie;

class TorrentMovieCustomController  extends TorrentMovieController {
    

	public function __construct(){
		$this->dao = new TorrentMovieCustomDAO();
		$this->view = new TorrentMovieCustomView();
	}

	
	
	public function addTorrent(Movie $movie) {
	    
	    if(!isset($_POST['enviar_torrent_movie'])){
	        $movieFileDao = new MovieFileDAO($this->dao->getConnection());
	        $listMovieFile = $movieFileDao->fetch();
	        
	        $this->view->showInsertForm($listMovieFile);
	        return;
	    }
	    if (! ( isset ( $_POST ['link'] ) &&  isset($_POST ['movie_file']))) {
	        echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing.
                </div>
	            
                ';
	        return;
	    }
	    $torrentMovie = new TorrentMovie();
	    $torrentMovie->setLink ( $_POST ['link'] );
	    $torrentMovie->getMovieFile()->setId ( $_POST ['movie_file'] );
	    
	    if ($this->dao->insert ($torrentMovie ))
	    {
	        echo '
	            
<div class="alert alert-success" role="alert">
  Sucesso ao inserir Torrent Movie
</div>
	            
';
	    } else {
	        echo '
	            
<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Torrent Movie
</div>
	            
';
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=torrent_movie">';
	}
	
	        
}
?>