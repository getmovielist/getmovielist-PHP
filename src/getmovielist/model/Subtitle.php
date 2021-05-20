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
	private $movieFile;
	private $lang;
    public function __construct(){

        $this->movieFile = new MovieFile();
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
	public function setMovieFile(MovieFile $movieFile) {
		$this->movieFile = $movieFile;
	}
		    
	public function getMovieFile() {
		return $this->movieFile;
	}
	public function setLang($lang) {
		$this->lang = $lang;
	}
		    
	public function getLang() {
		return $this->lang;
	}
	public function __toString(){
	    return $this->id.' - '.$this->label.' - '.$this->filePath.' - '.$this->movieFile.' - '.$this->lang;
	}
                

}
?>