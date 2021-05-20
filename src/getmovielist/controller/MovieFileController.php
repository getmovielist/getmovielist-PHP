<?php
            
/**
 * Classe feita para manipulação do objeto MovieFileController
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\controller;
use getmovielist\dao\MovieFileDAO;
use getmovielist\dao\MovieDAO;
use getmovielist\model\MovieFile;
use getmovielist\view\MovieFileView;


class MovieFileController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new MovieFileDAO();
		$this->view = new MovieFileView();
	}


    public function delete(){
	    if(!isset($_GET['delete'])){
	        return;
	    }
        $selected = new MovieFile();
	    $selected->setId($_GET['delete']);
        if(!isset($_POST['delete_movie_file'])){
            $this->view->confirmDelete($selected);
            return;
        }
        if($this->dao->delete($selected))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao excluir Movie File
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar excluir Movie File
</div>

';
		}
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?page=movie_file">';
    }



	public function fetch() 
    {
		$list = $this->dao->fetch();
		$this->view->showList($list);
	}


	public function add() {
            
        if(!isset($_POST['enviar_movie_file'])){
            $movieDao = new MovieDAO($this->dao->getConnection());
            $listMovie = $movieDao->fetch();

            $this->view->showInsertForm($listMovie);
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
		$movieFile = new MovieFile ();
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



            
	public function addAjax() {
            
        if(!isset($_POST['enviar_movie_file'])){
            return;    
        }
        
		    
		
		if (! ( isset ( $_POST ['file_path'] ) &&  isset($_POST ['movie']))) {
			echo ':incompleto';
			return;
		}
            
		$movieFile = new MovieFile ();
		$movieFile->setFilePath ( $_POST ['file_path'] );
		$movieFile->getMovie()->setId ( $_POST ['movie'] );
            
		if ($this->dao->insert ( $movieFile ))
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
        $selected = new MovieFile();
	    $selected->setId($_GET['edit']);
	    $this->dao->fillById($selected);
	        
        if(!isset($_POST['edit_movie_file'])){
            $movieDao = new MovieDAO($this->dao->getConnection());
            $listMovie = $movieDao->fetch();

            $this->view->showEditForm($listMovie, $selected);
            return;
        }
            
		if (! ( isset ( $_POST ['file_path'] ) &&  isset($_POST ['movie']))) {
			echo "Incompleto";
			return;
		}

		$selected->setFilePath ( $_POST ['file_path'] );
            
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
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=movie_file">';
            
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
        $selected = new MovieFile();
	    $selected->setId($_GET['select']);
	        
        $this->dao->fillById($selected);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->showSelected($selected);
        echo '</div>';
            

            
    }
}
?>