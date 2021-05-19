<?php
            
/**
 * Customize o controller do objeto AppUser aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\AppUserController;
use getmovielist\custom\dao\AppUserCustomDAO;
use getmovielist\custom\view\AppUserCustomView;

class AppUserCustomController  extends AppUserController {
    

	public function __construct(){
		$this->dao = new AppUserCustomDAO();
		$this->view = new AppUserCustomView();
	}


	        
}
?>