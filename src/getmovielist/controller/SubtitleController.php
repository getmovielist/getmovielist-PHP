<?php
            
/**
 * Classe feita para manipulação do objeto SubtitleController
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\controller;
use getmovielist\dao\SubtitleDAO;
use getmovielist\dao\MovieFileDAO;
use getmovielist\model\Subtitle;
use getmovielist\view\SubtitleView;


class SubtitleController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new SubtitleDAO();
		$this->view = new SubtitleView();
	}


    public function delete(){
	    if(!isset($_GET['delete'])){
	        return;
	    }
        $selected = new Subtitle();
	    $selected->setId($_GET['delete']);
        if(!isset($_POST['delete_subtitle'])){
            $this->view->confirmDelete($selected);
            return;
        }
        if($this->dao->delete($selected))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao excluir Subtitle
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar excluir Subtitle
</div>

';
		}
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?page=subtitle">';
    }



	public function fetch() 
    {
		$list = $this->dao->fetch();
		$this->view->showList($list);
	}


	public function add() {
            
        if(!isset($_POST['enviar_subtitle'])){
            $movieFileDao = new MovieFileDAO($this->dao->getConnection());
            $listMovieFile = $movieFileDao->fetch();

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
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=subtitle">';
	}



            
	public function addAjax() {
            
        if(!isset($_POST['enviar_subtitle'])){
            return;    
        }
        
		    
		
		if (! ( isset ( $_POST ['label'] ) && isset ( $_POST ['file_path'] ) && isset ( $_POST ['lang'] ) &&  isset($_POST ['movie_file']))) {
			echo ':incompleto';
			return;
		}
            
		$subtitle = new Subtitle ();
		$subtitle->setLabel ( $_POST ['label'] );
		$subtitle->setFilePath ( $_POST ['file_path'] );
		$subtitle->setLang ( $_POST ['lang'] );
		$subtitle->getMovieFile()->setId ( $_POST ['movie_file'] );
            
		if ($this->dao->insert ( $subtitle ))
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
        $selected = new Subtitle();
	    $selected->setId($_GET['edit']);
	    $this->dao->fillById($selected);
	        
        if(!isset($_POST['edit_subtitle'])){
            $moviefileDao = new MovieFileDAO($this->dao->getConnection());
            $listMovieFile = $moviefileDao->fetch();

            $this->view->showEditForm($listMovieFile, $selected);
            return;
        }
            
		if (! ( isset ( $_POST ['label'] ) && isset ( $_POST ['file_path'] ) && isset ( $_POST ['lang'] ) &&  isset($_POST ['movie_file']))) {
			echo "Incompleto";
			return;
		}

		$selected->setLabel ( $_POST ['label'] );
		$selected->setFilePath ( $_POST ['file_path'] );
		$selected->setLang ( $_POST ['lang'] );
            
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
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=subtitle">';
            
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
        $selected = new Subtitle();
	    $selected->setId($_GET['select']);
	        
        $this->dao->fillById($selected);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->showSelected($selected);
        echo '</div>';
            

            
    }
}
?>