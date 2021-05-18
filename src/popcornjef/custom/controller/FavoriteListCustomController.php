<?php
            
/**
 * Customize o controller do objeto FavoriteList aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace popcornjef\custom\controller;
use popcornjef\controller\FavoriteListController;
use popcornjef\custom\dao\FavoriteListCustomDAO;
use popcornjef\custom\view\FavoriteListCustomView;

class FavoriteListCustomController  extends FavoriteListController {
    

	public function __construct(){
		$this->dao = new FavoriteListCustomDAO();
		$this->view = new FavoriteListCustomView();
	}


	        
}
?>