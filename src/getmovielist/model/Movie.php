<?php
            
/**
 * Classe feita para manipulação do objeto Movie
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\model;

class Movie {
	private $id;
	private $movieFilePath;
	private $originalTitle;
	private $title;
	private $releaseDate;
	private $posterPath;
    public function __construct(){

    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setMovieFilePath($movieFilePath) {
		$this->movieFilePath = $movieFilePath;
	}
		    
	public function getMovieFilePath() {
		return $this->movieFilePath;
	}
	public function setOriginalTitle($originalTitle) {
		$this->originalTitle = $originalTitle;
	}
		    
	public function getOriginalTitle() {
		return $this->originalTitle;
	}
	public function setTitle($title) {
		$this->title = $title;
	}
		    
	public function getTitle() {
		return $this->title;
	}
	public function setReleaseDate($releaseDate) {
		$this->releaseDate = $releaseDate;
	}
		    
	public function getReleaseDate() {
		return $this->releaseDate;
	}
	public function setPosterPath($posterPath) {
		$this->posterPath = $posterPath;
	}
		    
	public function getPosterPath() {
		return $this->posterPath;
	}
	public function __toString(){
	    return $this->id.' - '.$this->movieFilePath.' - '.$this->originalTitle.' - '.$this->title.' - '.$this->releaseDate.' - '.$this->posterPath;
	}
                

}
?>