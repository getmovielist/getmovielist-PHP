<?php
            
/**
 * Classe feita para manipulação do objeto Comment
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\model;

class Comment {
	private $id;
	private $appUser;
	private $text;
	private $movie;
    public function __construct(){

        $this->appUser = new AppUser();
        $this->movie = new Movie();
    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setAppUser(AppUser $appUser) {
		$this->appUser = $appUser;
	}
		    
	public function getAppUser() {
		return $this->appUser;
	}
	public function setText($text) {
		$this->text = $text;
	}
		    
	public function getText() {
		return $this->text;
	}
	public function setMovie(Movie $movie) {
		$this->movie = $movie;
	}
		    
	public function getMovie() {
		return $this->movie;
	}
	public function __toString(){
	    return $this->id.' - '.$this->appUser.' - '.$this->text.' - '.$this->movie;
	}
                

}
?>