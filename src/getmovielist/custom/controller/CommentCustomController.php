<?php
            
/**
 * Customize o controller do objeto Comment aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\CommentController;
use getmovielist\custom\dao\CommentCustomDAO;
use getmovielist\custom\view\CommentCustomView;

class CommentCustomController  extends CommentController {
    

	public function __construct(){
		$this->dao = new CommentCustomDAO();
		$this->view = new CommentCustomView();
	}

	

	        
}
?>