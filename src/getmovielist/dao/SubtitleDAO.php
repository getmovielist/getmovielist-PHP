<?php
            
/**
 * Classe feita para manipulação do objeto Subtitle
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace getmovielist\dao;
use PDO;
use PDOException;
use getmovielist\model\Subtitle;

class SubtitleDAO extends DAO {
    
    

            
            
    public function update(Subtitle $subtitle)
    {
        $id = $subtitle->getId();
            
            
        $sql = "UPDATE subtitle
                SET
                label = :label,
                file_path = :filePath,
                lang = :lang
                WHERE subtitle.id = :id;";
			$label = $subtitle->getLabel();
			$filePath = $subtitle->getFilePath();
			$lang = $subtitle->getLang();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":label", $label, PDO::PARAM_STR);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
			$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(Subtitle $subtitle){
        $sql = "INSERT INTO subtitle(label, file_path, id_movie_file, lang) VALUES (:label, :filePath, :movieFile, :lang);";
		$label = $subtitle->getLabel();
		$filePath = $subtitle->getFilePath();
		$movieFile = $subtitle->getMovieFile()->getId();
		$lang = $subtitle->getLang();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":label", $label, PDO::PARAM_STR);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
			$stmt->bindParam(":movieFile", $movieFile, PDO::PARAM_INT);
			$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(Subtitle $subtitle){
        $sql = "INSERT INTO subtitle(id, label, file_path, id_movie_file, lang) VALUES (:id, :label, :filePath, :movieFile, :lang);";
		$id = $subtitle->getId();
		$label = $subtitle->getLabel();
		$filePath = $subtitle->getFilePath();
		$movieFile = $subtitle->getMovieFile()->getId();
		$lang = $subtitle->getLang();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":label", $label, PDO::PARAM_STR);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
			$stmt->bindParam(":movieFile", $movieFile, PDO::PARAM_INT);
			$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }

	public function delete(Subtitle $subtitle){
		$id = $subtitle->getId();
		$sql = "DELETE FROM subtitle WHERE id = :id";
		    
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
		$sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file LIMIT 1000";

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
		        $subtitle = new Subtitle();
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $list [] = $subtitle;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(Subtitle $subtitle) {
        $lista = array();
	    $id = $subtitle->getId();
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
            WHERE subtitle.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $subtitle = new Subtitle();
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $subtitle;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByLabel(Subtitle $subtitle) {
        $lista = array();
	    $label = $subtitle->getLabel();
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
            WHERE subtitle.label like :label";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":label", $label, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $subtitle = new Subtitle();
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $subtitle;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByFilePath(Subtitle $subtitle) {
        $lista = array();
	    $filePath = $subtitle->getFilePath();
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
            WHERE subtitle.file_path like :filePath";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $subtitle = new Subtitle();
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $subtitle;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByMovieFile(Subtitle $subtitle) {
        $lista = array();
	    $movieFile = $subtitle->getMovieFile()->getId();
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
            WHERE subtitle.id_movie_file = :movieFile";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":movieFile", $movieFile, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $subtitle = new Subtitle();
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $subtitle;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByLang(Subtitle $subtitle) {
        $lista = array();
	    $lang = $subtitle->getLang();
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
            WHERE subtitle.lang like :lang";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $subtitle = new Subtitle();
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $subtitle;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(Subtitle $subtitle) {
        
	    $id = $subtitle->getId();
	    $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
                WHERE subtitle.id = :id
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
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $subtitle;
    }
                
    public function fillByLabel(Subtitle $subtitle) {
        
	    $label = $subtitle->getLabel();
	    $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
                WHERE subtitle.label = :label
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":label", $label, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $subtitle;
    }
                
    public function fillByFilePath(Subtitle $subtitle) {
        
	    $filePath = $subtitle->getFilePath();
	    $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
                WHERE subtitle.file_path = :filePath
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $subtitle;
    }
                
    public function fillByLang(Subtitle $subtitle) {
        
	    $lang = $subtitle->getLang();
	    $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, subtitle.lang, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM subtitle INNER JOIN movie_file as movie_file ON movie_file.id = subtitle.id_movie_file
                WHERE subtitle.lang = :lang
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->setLang( $row ['lang'] );
                $subtitle->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $subtitle->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $subtitle;
    }
}