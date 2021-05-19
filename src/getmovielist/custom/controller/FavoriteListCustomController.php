<?php
            
/**
 * Customize o controller do objeto FavoriteList aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\FavoriteListController;
use getmovielist\custom\dao\FavoriteListCustomDAO;
use getmovielist\custom\view\FavoriteListCustomView;

class FavoriteListCustomController  extends FavoriteListController {
    

	public function __construct(){
		$this->dao = new FavoriteListCustomDAO();
		$this->view = new FavoriteListCustomView();
	}


	        
}
?>