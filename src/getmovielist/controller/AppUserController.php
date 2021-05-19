<?php
            
/**
 * Classe feita para manipulação do objeto AppUserController
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\controller;
use getmovielist\dao\AppUserDAO;
use getmovielist\model\AppUser;
use getmovielist\view\AppUserView;


class AppUserController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new AppUserDAO();
		$this->view = new AppUserView();
	}


    public function delete(){
	    if(!isset($_GET['delete'])){
	        return;
	    }
        $selected = new AppUser();
	    $selected->setId($_GET['delete']);
        if(!isset($_POST['delete_app_user'])){
            $this->view->confirmDelete($selected);
            return;
        }
        if($this->dao->delete($selected))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao excluir App User
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar excluir App User
</div>

';
		}
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?page=app_user">';
    }



	public function fetch() 
    {
		$list = $this->dao->fetch();
		$this->view->showList($list);
	}


	public function add() {
            
        if(!isset($_POST['enviar_app_user'])){
            $this->view->showInsertForm();
		    return;
		}
		if (! ( isset ( $_POST ['name'] ) && isset ( $_POST ['email'] ) && isset ( $_POST ['login'] ) && isset ( $_POST ['password'] ) && isset ( $_POST ['level'] ))) {
			echo '
                <div class="alert alert-danger" role="alert">
                    Failed to register. Some field must be missing. 
                </div>

                ';
			return;
		}
		$appUser = new AppUser ();
		$appUser->setName ( $_POST ['name'] );
		$appUser->setEmail ( $_POST ['email'] );
		$appUser->setLogin ( $_POST ['login'] );
		$appUser->setPassword ( $_POST ['password'] );
		$appUser->setLevel ( $_POST ['level'] );
            
		if ($this->dao->insert ($appUser ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao inserir App User
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir App User
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=app_user">';
	}



            
	public function addAjax() {
            
        if(!isset($_POST['enviar_app_user'])){
            return;    
        }
        
		    
		
		if (! ( isset ( $_POST ['name'] ) && isset ( $_POST ['email'] ) && isset ( $_POST ['login'] ) && isset ( $_POST ['password'] ) && isset ( $_POST ['level'] ))) {
			echo ':incompleto';
			return;
		}
            
		$appUser = new AppUser ();
		$appUser->setName ( $_POST ['name'] );
		$appUser->setEmail ( $_POST ['email'] );
		$appUser->setLogin ( $_POST ['login'] );
		$appUser->setPassword ( $_POST ['password'] );
		$appUser->setLevel ( $_POST ['level'] );
            
		if ($this->dao->insert ( $appUser ))
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
        $selected = new AppUser();
	    $selected->setId($_GET['edit']);
	    $this->dao->fillById($selected);
	        
        if(!isset($_POST['edit_app_user'])){
            $this->view->showEditForm($selected);
            return;
        }
            
		if (! ( isset ( $_POST ['name'] ) && isset ( $_POST ['email'] ) && isset ( $_POST ['login'] ) && isset ( $_POST ['password'] ) && isset ( $_POST ['level'] ))) {
			echo "Incompleto";
			return;
		}

		$selected->setName ( $_POST ['name'] );
		$selected->setEmail ( $_POST ['email'] );
		$selected->setLogin ( $_POST ['login'] );
		$selected->setPassword ( $_POST ['password'] );
		$selected->setLevel ( $_POST ['level'] );
            
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
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?page=app_user">';
            
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
        $selected = new AppUser();
	    $selected->setId($_GET['select']);
	        
        $this->dao->fillById($selected);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->showSelected($selected);
        echo '</div>';
            

            
    }
}
?>