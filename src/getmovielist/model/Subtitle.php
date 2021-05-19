<?php
            
/**
 * Classe feita para manipulação do objeto Subtitle
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\model;

class Subtitle {
	private $id;
	private $label;
	private $filePath;
	private $movie;
    public function __construct(){

        $this->movie = new Movie();
    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setLabel($label) {
		$this->label = $label;
	}
		    
	public function getLabel() {
		return $this->label;
	}
	public function setFilePath($filePath) {
		$this->filePath = $filePath;
	}
		    
	public function getFilePath() {
		return $this->filePath;
	}
	public function setMovie(Movie $movie) {
		$this->movie = $movie;
	}
		    
	public function getMovie() {
		return $this->movie;
	}
	public function __toString(){
	    return $this->id.' - '.$this->label.' - '.$this->filePath.' - '.$this->movie;
	}
                

}
?>