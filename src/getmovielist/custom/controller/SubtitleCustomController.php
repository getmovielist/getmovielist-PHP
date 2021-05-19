<?php
            
/**
 * Customize o controller do objeto Subtitle aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\SubtitleController;
use getmovielist\custom\dao\SubtitleCustomDAO;
use getmovielist\custom\view\SubtitleCustomView;

class SubtitleCustomController  extends SubtitleController {
    

	public function __construct(){
		$this->dao = new SubtitleCustomDAO();
		$this->view = new SubtitleCustomView();
	}


	        
}
?>