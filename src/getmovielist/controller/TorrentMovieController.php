<?php
            
/**
 * Classe feita para manipulação do objeto TorrentMovieController
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\controller;
use getmovielist\dao\TorrentMovieDAO;
use getmovielist\dao\MovieFileDAO;
use getmovielist\model\TorrentMovie;
use getmovielist\view\TorrentMovieView;


class TorrentMovieController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new TorrentMovieDAO();
		$this->view = new TorrentMovieView();
	}


    public function delete(){
	    if(!isset($_GET['delete'])){
	        return;
	    }
        $selected = new TorrentMovie();
	    $selected->setId($_GET['delete']);
        if(!isset($_POST['delete_torrent_movie'])){
            $this->view->confirmDelete($selected);
            return;
        }
        if($this->dao->delete($selected))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao excluir Torrent Movie
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar excluir Torrent Movie
</div>

';
		}
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?page=torrent_movie">';
    }



	public function fetch() 
    {
		$list = $this->dao->fetch();
		$this->view->showList($list);
	}


	public function add() {
            
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
		$torrentMovie = new TorrentMovie ();
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



            
	public function addAjax() {
            
        if(!isset($_POST['enviar_torrent_movie'])){
            return;    
        }
        
		    
		
		if (! ( isset ( $_POST ['link'] ) &&  isset($_POST ['movie_file']))) {
			echo ':incompleto';
			return;
		}
            
		$torrentMovie = new TorrentMovie ();
		$torrentMovie->setLink ( $_POST ['link'] );
		$torrentMovie->getMovieFile()->setId ( $_POST ['movie_file'] );
            
		if ($this->dao->insert ( $torrentMovie ))
        {
			$id = $this->dao->getConnection()->lastInsertId();
            echo ':sucesso:'.$id;
            
		} else {
			 echo ':falha';
		}
	}
            
            

            
    public function edit(){
	    if(!isset($_GET['edit'])){
	        return;
	    }
        $selected = new TorrentMovie();
	    $selected->setId($_GET['edit']);
	    $this->dao->fillById($selected);
	        
        if(!isset($_POST['edit_torrent_movie'])){
            $moviefileDao = new MovieFileDAO($this->dao->getConnection());
            $listMovieFile = $moviefileDao->fetch();

            $this->view->showEditForm($listMovieFile, $selected);
            return;
        }
            
		if (! ( isset ( $_POST ['link'] ) &&  isset($_POST ['movie_file']))) {
			echo "Incompleto";
			return;
		}

		$selected->setLink ( $_POST ['link'] );
            
		if ($this->dao->update ($selected ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso 
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha 
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=torrent_movie">';
            
    }
        

    public function main(){
        
        if (isset($_GET['select'])){
            echo '<div class="row">';
                $this->select();
            echo '</div>';
            return;
        }
        echo '
		<div class="row">';
        echo '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">';
        
        if(isset($_GET['edit'])){
            $this->edit();
        }else if(isset($_GET['delete'])){
            $this->delete();
	    }else{
            $this->add();
        }
        $this->fetch();
        
        echo '</div>';
        echo '</div>';
            
    }
    public function mainAjax(){

        $this->addAjax();
        
            
    }


            
    public function select(){
	    if(!isset($_GET['select'])){
	        return;
	    }
        $selected = new TorrentMovie();
	    $selected->setId($_GET['select']);
	        
        $this->dao->fillById($selected);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->showSelected($selected);
        echo '</div>';
            

            
    }
}
?>