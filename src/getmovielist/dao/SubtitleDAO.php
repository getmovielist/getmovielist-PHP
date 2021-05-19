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
                file_path = :filePath
                WHERE subtitle.id = :id;";
			$label = $subtitle->getLabel();
			$filePath = $subtitle->getFilePath();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":label", $label, PDO::PARAM_STR);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(Subtitle $subtitle){
        $sql = "INSERT INTO subtitle(label, file_path, id_movie) VALUES (:label, :filePath, :movie);";
		$label = $subtitle->getLabel();
		$filePath = $subtitle->getFilePath();
		$movie = $subtitle->getMovie()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":label", $label, PDO::PARAM_STR);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(Subtitle $subtitle){
        $sql = "INSERT INTO subtitle(id, label, file_path, id_movie) VALUES (:id, :label, :filePath, :movie);";
		$id = $subtitle->getId();
		$label = $subtitle->getLabel();
		$filePath = $subtitle->getFilePath();
		$movie = $subtitle->getMovie()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":label", $label, PDO::PARAM_STR);
			$stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
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
		$sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie LIMIT 1000";

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
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
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
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie
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
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
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
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie
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
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
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
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie
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
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                $lista [] = $subtitle;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByMovie(Subtitle $subtitle) {
        $lista = array();
	    $movie = $subtitle->getMovie()->getId();
                
        $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie
            WHERE subtitle.id_movie = :movie";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $subtitle = new Subtitle();
                $subtitle->setId( $row ['id'] );
                $subtitle->setLabel( $row ['label'] );
                $subtitle->setFilePath( $row ['file_path'] );
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                $lista [] = $subtitle;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(Subtitle $subtitle) {
        
	    $id = $subtitle->getId();
	    $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie
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
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $subtitle;
    }
                
    public function fillByLabel(Subtitle $subtitle) {
        
	    $label = $subtitle->getLabel();
	    $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie
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
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $subtitle;
    }
                
    public function fillByFilePath(Subtitle $subtitle) {
        
	    $filePath = $subtitle->getFilePath();
	    $sql = "SELECT subtitle.id, subtitle.label, subtitle.file_path, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.original_title as original_title_movie_movie, movie.title as title_movie_movie, movie.release_date as release_date_movie_movie, movie.poster_path as poster_path_movie_movie FROM subtitle INNER JOIN movie as movie ON movie.id = subtitle.id_movie
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
                $subtitle->getMovie()->setId( $row ['id_movie_movie'] );
                $subtitle->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $subtitle->getMovie()->setOriginalTitle( $row ['original_title_movie_movie'] );
                $subtitle->getMovie()->setTitle( $row ['title_movie_movie'] );
                $subtitle->getMovie()->setReleaseDate( $row ['release_date_movie_movie'] );
                $subtitle->getMovie()->setPosterPath( $row ['poster_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $subtitle;
    }
}