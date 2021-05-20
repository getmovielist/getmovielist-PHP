<?php
            
/**
 * Customize o controller do objeto MovieFile aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\MovieFileController;
use getmovielist\custom\dao\MovieFileCustomDAO;
use getmovielist\custom\view\MovieFileCustomView;

class MovieFileCustomController  extends MovieFileController {
    

	public function __construct(){
		$this->dao = new MovieFileCustomDAO();
		$this->view = new MovieFileCustomView();
	}


	        
}
?>