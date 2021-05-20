<?php
            
/**
 * Customize o controller do objeto TorrentMovie aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */

namespace getmovielist\custom\controller;
use getmovielist\controller\TorrentMovieController;
use getmovielist\custom\dao\TorrentMovieCustomDAO;
use getmovielist\custom\view\TorrentMovieCustomView;

class TorrentMovieCustomController  extends TorrentMovieController {
    

	public function __construct(){
		$this->dao = new TorrentMovieCustomDAO();
		$this->view = new TorrentMovieCustomView();
	}


	        
}
?>