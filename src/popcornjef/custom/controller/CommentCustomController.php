<?php
            
/**
 * Customize o controller do objeto Comment aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace popcornjef\custom\controller;
use popcornjef\controller\CommentController;
use popcornjef\custom\dao\CommentCustomDAO;
use popcornjef\custom\view\CommentCustomView;

class CommentCustomController  extends CommentController {
    

	public function __construct(){
		$this->dao = new CommentCustomDAO();
		$this->view = new CommentCustomView();
	}


	        
}
?>