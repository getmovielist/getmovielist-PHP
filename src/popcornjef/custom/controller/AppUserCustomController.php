<?php
            
/**
 * Customize o controller do objeto AppUser aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace popcornjef\custom\controller;
use popcornjef\controller\AppUserController;
use popcornjef\custom\dao\AppUserCustomDAO;
use popcornjef\custom\view\AppUserCustomView;

class AppUserCustomController  extends AppUserController {
    

	public function __construct(){
		$this->dao = new AppUserCustomDAO();
		$this->view = new AppUserCustomView();
	}


	        
}
?>