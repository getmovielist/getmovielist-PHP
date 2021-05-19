<?php
            
/**
 * Classe feita para manipulação do objeto MovieController
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\controller;
use getmovielist\dao\MovieDAO;
use getmovielist\model\Movie;
use getmovielist\view\MovieView;


class MovieController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new MovieDAO();
		$this->view = new MovieView();
	}


    public function delete(){
	    if(!isset($_GET['delete'])){
	        return;
	    }
        $selected = new Movie();
	    $selected->setId($_GET['delete']);
        if(!isset($_POST['delete_movie'])){
            $this->view->confirmDelete($selected);
            return;
        }
        if($this->dao->delete($selected))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao excluir Movie
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar excluir Movie
</div>

';
		}
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?page=movie">';
    }



	public function fetch() 
    {
		$list = $this->dao->fetch();
		$this->view->showList($list);
	}


	public function add() {
            
        if(!isset($_POST['enviar_movie'])){
            $this->view->showInsertForm();
		    return;
		}
		if (! ( isset ( $_POST ['movie_file_path'] ) && isset ( $_POST ['original_title'] ) && isset ( $_POST ['title'] ) && isset ( $_POST ['release_date'] ) && isset ( $_POST ['poster_path'] ))) {
			echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing. 
                </div>

                ';
			return;
		}
		$movie = new Movie ();
		$movie->setMovieFilePath ( $_POST ['movie_file_path'] );
		$movie->setOriginalTitle ( $_POST ['original_title'] );
		$movie->setTitle ( $_POST ['title'] );
		$movie->setReleaseDate ( $_POST ['release_date'] );
		$movie->setPosterPath ( $_POST ['poster_path'] );
            
		if ($this->dao->insert ($movie ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao inserir Movie
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Movie
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=movie">';
	}



            
	public function addAjax() {
            
        if(!isset($_POST['enviar_movie'])){
            return;    
        }
        
		    
		
		if (! ( isset ( $_POST ['movie_file_path'] ) && isset ( $_POST ['original_title'] ) && isset ( $_POST ['title'] ) && isset ( $_POST ['release_date'] ) && isset ( $_POST ['poster_path'] ))) {
			echo ':incompleto';
			return;
		}
            
		$movie = new Movie ();
		$movie->setMovieFilePath ( $_POST ['movie_file_path'] );
		$movie->setOriginalTitle ( $_POST ['original_title'] );
		$movie->setTitle ( $_POST ['title'] );
		$movie->setReleaseDate ( $_POST ['release_date'] );
		$movie->setPosterPath ( $_POST ['poster_path'] );
            
		if ($this->dao->insert ( $movie ))
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
        $selected = new Movie();
	    $selected->setId($_GET['edit']);
	    $this->dao->fillById($selected);
	        
        if(!isset($_POST['edit_movie'])){
            $this->view->showEditForm($selected);
            return;
        }
            
		if (! ( isset ( $_POST ['movie_file_path'] ) && isset ( $_POST ['original_title'] ) && isset ( $_POST ['title'] ) && isset ( $_POST ['release_date'] ) && isset ( $_POST ['poster_path'] ))) {
			echo "Incompleto";
			return;
		}

		$selected->setMovieFilePath ( $_POST ['movie_file_path'] );
		$selected->setOriginalTitle ( $_POST ['original_title'] );
		$selected->setTitle ( $_POST ['title'] );
		$selected->setReleaseDate ( $_POST ['release_date'] );
		$selected->setPosterPath ( $_POST ['poster_path'] );
            
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
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=movie">';
            
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
        $selected = new Movie();
	    $selected->setId($_GET['select']);
	        
        $this->dao->fillById($selected);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->showSelected($selected);
        echo '</div>';
            

            
    }
}
?>