<?php
            
/**
 * Classe feita para manipulação do objeto MovieFile
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace getmovielist\dao;
use PDO;
use PDOException;
use getmovielist\model\MovieFile;

class MovieFileDAO extends DAO {
    
    

            
            
    public function update(MovieFile $movieFile)
    {
        $id = $movieFile->getId();
            
            
        $sql = "UPDATE movie_file
                SET
                file_path = :filePath
                WHERE movie_file.id = :id;";
			$filePath = $movieFile->getFilePath();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(MovieFile $movieFile){
        $sql = "INSERT INTO movie_file(id_movie, file_path) VALUES (:movie, :filePath);";
		$movie = $movieFile->getMovie()->getId();
		$filePath = $movieFile->getFilePath();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(MovieFile $movieFile){
        $sql = "INSERT INTO movie_file(id, id_movie, file_path) VALUES (:id, :movie, :filePath);";
		$id = $movieFile->getId();
		$movie = $movieFile->getMovie()->getId();
		$filePath = $movieFile->getFilePath();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }

	public function delete(MovieFile $movieFile){
		$id = $movieFile->getId();
		$sql = "DELETE FROM movie_file WHERE id = :id";
		    
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
		$sql = "SELECT movie_file.id, movie_file.file_path, movie.id as id_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM movie_file INNER JOIN movie as movie ON movie.id = movie_file.id_movie LIMIT 1000";

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
		        $movieFile = new MovieFile();
                $movieFile->setId( $row ['id'] );
                $movieFile->setFilePath( $row ['file_path'] );
                $movieFile->getMovie()->setId( $row ['id_movie_movie'] );
                $movieFile->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $movieFile->getMovie()->setTitle( $row ['title_movie_movie'] );
                $movieFile->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $movieFile->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                $list [] = $movieFile;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(MovieFile $movieFile) {
        $lista = array();
	    $id = $movieFile->getId();
                
        $sql = "SELECT movie_file.id, movie_file.file_path, movie.id as id_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM movie_file INNER JOIN movie as movie ON movie.id = movie_file.id_movie
            WHERE movie_file.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movieFile = new MovieFile();
                $movieFile->setId( $row ['id'] );
                $movieFile->setFilePath( $row ['file_path'] );
                $movieFile->getMovie()->setId( $row ['id_movie_movie'] );
                $movieFile->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $movieFile->getMovie()->setTitle( $row ['title_movie_movie'] );
                $movieFile->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $movieFile->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                $lista [] = $movieFile;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByMovie(MovieFile $movieFile) {
        $lista = array();
	    $movie = $movieFile->getMovie()->getId();
                
        $sql = "SELECT movie_file.id, movie_file.file_path, movie.id as id_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM movie_file INNER JOIN movie as movie ON movie.id = movie_file.id_movie
            WHERE movie_file.id_movie = :movie";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movieFile = new MovieFile();
                $movieFile->setId( $row ['id'] );
                $movieFile->setFilePath( $row ['file_path'] );
                $movieFile->getMovie()->setId( $row ['id_movie_movie'] );
                $movieFile->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $movieFile->getMovie()->setTitle( $row ['title_movie_movie'] );
                $movieFile->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $movieFile->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                $lista [] = $movieFile;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByFilePath(MovieFile $movieFile) {
        $lista = array();
	    $filePath = $movieFile->getFilePath();
                
        $sql = "SELECT movie_file.id, movie_file.file_path, movie.id as id_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM movie_file INNER JOIN movie as movie ON movie.id = movie_file.id_movie
            WHERE movie_file.file_path like :filePath";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movieFile = new MovieFile();
                $movieFile->setId( $row ['id'] );
                $movieFile->setFilePath( $row ['file_path'] );
                $movieFile->getMovie()->setId( $row ['id_movie_movie'] );
                $movieFile->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $movieFile->getMovie()->setTitle( $row ['title_movie_movie'] );
                $movieFile->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $movieFile->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                $lista [] = $movieFile;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(MovieFile $movieFile) {
        
	    $id = $movieFile->getId();
	    $sql = "SELECT movie_file.id, movie_file.file_path, movie.id as id_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM movie_file INNER JOIN movie as movie ON movie.id = movie_file.id_movie
                WHERE movie_file.id = :id
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
                $movieFile->setId( $row ['id'] );
                $movieFile->setFilePath( $row ['file_path'] );
                $movieFile->getMovie()->setId( $row ['id_movie_movie'] );
                $movieFile->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $movieFile->getMovie()->setTitle( $row ['title_movie_movie'] );
                $movieFile->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $movieFile->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movieFile;
    }
                
    public function fillByFilePath(MovieFile $movieFile) {
        
	    $filePath = $movieFile->getFilePath();
	    $sql = "SELECT movie_file.id, movie_file.file_path, movie.id as id_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM movie_file INNER JOIN movie as movie ON movie.id = movie_file.id_movie
                WHERE movie_file.file_path = :filePath
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
                $movieFile->setId( $row ['id'] );
                $movieFile->setFilePath( $row ['file_path'] );
                $movieFile->getMovie()->setId( $row ['id_movie_movie'] );
                $movieFile->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $movieFile->getMovie()->setTitle( $row ['title_movie_movie'] );
                $movieFile->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $movieFile->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movieFile;
    }
}