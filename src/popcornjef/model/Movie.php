<?php
            
/**
 * Classe feita para manipulação do objeto Movie
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace popcornjef\model;

class Movie {
	private $id;
	private $movieFilePath;
	private $torrentLink;
	private $subtitleBrPath;
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
	public function setTorrentLink($torrentLink) {
		$this->torrentLink = $torrentLink;
	}
		    
	public function getTorrentLink() {
		return $this->torrentLink;
	}
	public function setSubtitleBrPath($subtitleBrPath) {
		$this->subtitleBrPath = $subtitleBrPath;
	}
		    
	public function getSubtitleBrPath() {
		return $this->subtitleBrPath;
	}
	public function __toString(){
	    return $this->id.' - '.$this->movieFilePath.' - '.$this->torrentLink.' - '.$this->subtitleBrPath;
	}
                

}
?>