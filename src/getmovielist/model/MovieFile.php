<?php
            
/**
 * Classe feita para manipulação do objeto MovieFile
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\model;

class MovieFile {
	private $id;
	private $movie;
	private $filePath;
    public function __construct(){

        $this->movie = new Movie();
    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setMovie(Movie $movie) {
		$this->movie = $movie;
	}
		    
	public function getMovie() {
		return $this->movie;
	}
	public function setFilePath($filePath) {
		$this->filePath = $filePath;
	}
		    
	public function getFilePath() {
		return $this->filePath;
	}
	public function __toString(){
	    return $this->id.' - '.$this->movie.' - '.$this->filePath;
	}
                

}
?>