<?php
            
/**
 * Classe feita para manipulação do objeto CommentController
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace popcornjef\controller;
use popcornjef\dao\CommentDAO;
use popcornjef\dao\AppUserDAO;
use popcornjef\dao\MovieDAO;
use popcornjef\model\Comment;
use popcornjef\view\CommentView;


class CommentController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new CommentDAO();
		$this->view = new CommentView();
	}


    public function delete(){
	    if(!isset($_GET['delete'])){
	        return;
	    }
        $selected = new Comment();
	    $selected->setId($_GET['delete']);
        if(!isset($_POST['delete_comment'])){
            $this->view->confirmDelete($selected);
            return;
        }
        if($this->dao->delete($selected))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao excluir Comment
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar excluir Comment
</div>

';
		}
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?page=comment">';
    }



	public function fetch() 
    {
		$list = $this->dao->fetch();
		$this->view->showList($list);
	}


	public function add() {
            
        if(!isset($_POST['enviar_comment'])){
            $appUserDao = new AppUserDAO($this->dao->getConnection());
            $listAppUser = $appUserDao->fetch();

            $movieDao = new MovieDAO($this->dao->getConnection());
            $listMovie = $movieDao->fetch();

            $this->view->showInsertForm($listAppUser, $listMovie);
		    return;
		}
		if (! ( isset ( $_POST ['text'] ) &&  isset($_POST ['app_user']) &&  isset($_POST ['movie']))) {
			echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing. 
                </div>

                ';
			return;
		}
		$comment = new Comment ();
		$comment->setText ( $_POST ['text'] );
		$comment->getAppUser()->setId ( $_POST ['app_user'] );
		$comment->getMovie()->setId ( $_POST ['movie'] );
            
		if ($this->dao->insert ($comment ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao inserir Comment
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Comment
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=comment">';
	}



            
	public function addAjax() {
            
        if(!isset($_POST['enviar_comment'])){
            return;    
        }
        
		    
		
		if (! ( isset ( $_POST ['text'] ) &&  isset($_POST ['app_user']) &&  isset($_POST ['movie']))) {
			echo ':incompleto';
			return;
		}
            
		$comment = new Comment ();
		$comment->setText ( $_POST ['text'] );
		$comment->getAppUser()->setId ( $_POST ['app_user'] );
		$comment->getMovie()->setId ( $_POST ['movie'] );
            
		if ($this->dao->insert ( $comment ))
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
        $selected = new Comment();
	    $selected->setId($_GET['edit']);
	    $this->dao->fillById($selected);
	        
        if(!isset($_POST['edit_comment'])){
            $appuserDao = new AppUserDAO($this->dao->getConnection());
            $listAppUser = $appuserDao->fetch();

            $movieDao = new MovieDAO($this->dao->getConnection());
            $listMovie = $movieDao->fetch();

            $this->view->showEditForm($listAppUser, $listMovie, $selected);
            return;
        }
            
		if (! ( isset ( $_POST ['text'] ) &&  isset($_POST ['app_user']) &&  isset($_POST ['movie']))) {
			echo "Incompleto";
			return;
		}

		$selected->setText ( $_POST ['text'] );
            
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
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=comment">';
            
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
        $selected = new Comment();
	    $selected->setId($_GET['select']);
	        
        $this->dao->fillById($selected);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->showSelected($selected);
        echo '</div>';
            

            
    }
}
?>