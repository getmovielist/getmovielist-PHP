<?php
            
/**
 * Classe feita para manipulação do objeto AppUser
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

namespace popcornjef\model;

class AppUser {
	private $id;
	private $name;
	private $email;
	private $login;
	private $password;
	private $level;
    public function __construct(){

    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setName($name) {
		$this->name = $name;
	}
		    
	public function getName() {
		return $this->name;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
		    
	public function getEmail() {
		return $this->email;
	}
	public function setLogin($login) {
		$this->login = $login;
	}
		    
	public function getLogin() {
		return $this->login;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
		    
	public function getPassword() {
		return $this->password;
	}
	public function setLevel($level) {
		$this->level = $level;
	}
		    
	public function getLevel() {
		return $this->level;
	}
	public function __toString(){
	    return $this->id.' - '.$this->name.' - '.$this->email.' - '.$this->login.' - '.$this->password.' - '.$this->level;
	}
                

}
?>