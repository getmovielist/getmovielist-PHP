<?php
            
/**
 * Classe feita para manipulação do objeto TorrentMovie
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace getmovielist\model;

class TorrentMovie {
	private $id;
	private $link;
	private $movieFile;
    public function __construct(){

        $this->movieFile = new MovieFile();
    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setLink($link) {
		$this->link = $link;
	}
		    
	public function getLink() {
		return $this->link;
	}
	public function setMovieFile(MovieFile $movieFile) {
		$this->movieFile = $movieFile;
	}
		    
	public function getMovieFile() {
		return $this->movieFile;
	}
	public function __toString(){
	    return $this->id.' - '.$this->link.' - '.$this->movieFile;
	}
                

}
?>