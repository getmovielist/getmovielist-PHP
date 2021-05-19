<?php
            
/**
 * Classe feita para manipulação do objeto AppUser
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace getmovielist\dao;
use PDO;
use PDOException;
use getmovielist\model\AppUser;

class AppUserDAO extends DAO {
    
    

            
            
    public function update(AppUser $appUser)
    {
        $id = $appUser->getId();
            
            
        $sql = "UPDATE app_user
                SET
                name = :name,
                email = :email,
                login = :login,
                password = :password,
                level = :level
                WHERE app_user.id = :id;";
			$name = $appUser->getName();
			$email = $appUser->getEmail();
			$login = $appUser->getLogin();
			$password = $appUser->getPassword();
			$level = $appUser->getLevel();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":login", $login, PDO::PARAM_STR);
			$stmt->bindParam(":password", $password, PDO::PARAM_STR);
			$stmt->bindParam(":level", $level, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(AppUser $appUser){
        $sql = "INSERT INTO app_user(name, email, login, password, level) VALUES (:name, :email, :login, :password, :level);";
		$name = $appUser->getName();
		$email = $appUser->getEmail();
		$login = $appUser->getLogin();
		$password = $appUser->getPassword();
		$level = $appUser->getLevel();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":login", $login, PDO::PARAM_STR);
			$stmt->bindParam(":password", $password, PDO::PARAM_STR);
			$stmt->bindParam(":level", $level, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(AppUser $appUser){
        $sql = "INSERT INTO app_user(id, name, email, login, password, level) VALUES (:id, :name, :email, :login, :password, :level);";
		$id = $appUser->getId();
		$name = $appUser->getName();
		$email = $appUser->getEmail();
		$login = $appUser->getLogin();
		$password = $appUser->getPassword();
		$level = $appUser->getLevel();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":login", $login, PDO::PARAM_STR);
			$stmt->bindParam(":password", $password, PDO::PARAM_STR);
			$stmt->bindParam(":level", $level, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }

	public function delete(AppUser $appUser){
		$id = $appUser->getId();
		$sql = "DELETE FROM app_user WHERE id = :id";
		    
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			return $stmt->execute();
			    
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}


	public function fetch() {
		$list = array ();
		$sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user LIMIT 1000";

        try {
            $stmt = $this->connection->prepare($sql);
            
		    if(!$stmt){   
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		        return $list;
		    }
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row) 
            {
		        $appUser = new AppUser();
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                $list [] = $appUser;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(AppUser $appUser) {
        $lista = array();
	    $id = $appUser->getId();
                
        $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
            WHERE app_user.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $appUser = new AppUser();
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                $lista [] = $appUser;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByName(AppUser $appUser) {
        $lista = array();
	    $name = $appUser->getName();
                
        $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
            WHERE app_user.name like :name";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $appUser = new AppUser();
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                $lista [] = $appUser;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByEmail(AppUser $appUser) {
        $lista = array();
	    $email = $appUser->getEmail();
                
        $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
            WHERE app_user.email like :email";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $appUser = new AppUser();
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                $lista [] = $appUser;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByLogin(AppUser $appUser) {
        $lista = array();
	    $login = $appUser->getLogin();
                
        $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
            WHERE app_user.login like :login";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $appUser = new AppUser();
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                $lista [] = $appUser;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByPassword(AppUser $appUser) {
        $lista = array();
	    $password = $appUser->getPassword();
                
        $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
            WHERE app_user.password like :password";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $appUser = new AppUser();
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                $lista [] = $appUser;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByLevel(AppUser $appUser) {
        $lista = array();
	    $level = $appUser->getLevel();
                
        $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
            WHERE app_user.level = :level";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":level", $level, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $appUser = new AppUser();
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                $lista [] = $appUser;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(AppUser $appUser) {
        
	    $id = $appUser->getId();
	    $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
                WHERE app_user.id = :id
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $appUser;
    }
                
    public function fillByName(AppUser $appUser) {
        
	    $name = $appUser->getName();
	    $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
                WHERE app_user.name = :name
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $appUser;
    }
                
    public function fillByEmail(AppUser $appUser) {
        
	    $email = $appUser->getEmail();
	    $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
                WHERE app_user.email = :email
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $appUser;
    }
                
    public function fillByLogin(AppUser $appUser) {
        
	    $login = $appUser->getLogin();
	    $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
                WHERE app_user.login = :login
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $appUser;
    }
                
    public function fillByPassword(AppUser $appUser) {
        
	    $password = $appUser->getPassword();
	    $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
                WHERE app_user.password = :password
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $appUser;
    }
                
    public function fillByLevel(AppUser $appUser) {
        
	    $level = $appUser->getLevel();
	    $sql = "SELECT app_user.id, app_user.name, app_user.email, app_user.login, app_user.password, app_user.level FROM app_user
                WHERE app_user.level = :level
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":level", $level, PDO::PARAM_INT);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $appUser->setId( $row ['id'] );
                $appUser->setName( $row ['name'] );
                $appUser->setEmail( $row ['email'] );
                $appUser->setLogin( $row ['login'] );
                $appUser->setPassword( $row ['password'] );
                $appUser->setLevel( $row ['level'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $appUser;
    }
}