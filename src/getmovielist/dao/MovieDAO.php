<?php
            
/**
 * Classe feita para manipulação do objeto Movie
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace getmovielist\dao;
use PDO;
use PDOException;
use getmovielist\model\Movie;

class MovieDAO extends DAO {
    
    

            
            
    public function update(Movie $movie)
    {
        $id = $movie->getId();
            
            
        $sql = "UPDATE movie
                SET
                original_title = :originalTitle,
                title = :title,
                release_date = :releaseDate,
                poster_path = :posterPath
                WHERE movie.id = :id;";
			$originalTitle = $movie->getOriginalTitle();
			$title = $movie->getTitle();
			$releaseDate = $movie->getReleaseDate();
			$posterPath = $movie->getPosterPath();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":originalTitle", $originalTitle, PDO::PARAM_STR);
			$stmt->bindParam(":title", $title, PDO::PARAM_STR);
			$stmt->bindParam(":releaseDate", $releaseDate, PDO::PARAM_STR);
			$stmt->bindParam(":posterPath", $posterPath, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(Movie $movie){
        $sql = "INSERT INTO movie(original_title, title, release_date, poster_path) VALUES (:originalTitle, :title, :releaseDate, :posterPath);";
		$originalTitle = $movie->getOriginalTitle();
		$title = $movie->getTitle();
		$releaseDate = $movie->getReleaseDate();
		$posterPath = $movie->getPosterPath();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":originalTitle", $originalTitle, PDO::PARAM_STR);
			$stmt->bindParam(":title", $title, PDO::PARAM_STR);
			$stmt->bindParam(":releaseDate", $releaseDate, PDO::PARAM_STR);
			$stmt->bindParam(":posterPath", $posterPath, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(Movie $movie){
        $sql = "INSERT INTO movie(id, original_title, title, release_date, poster_path) VALUES (:id, :originalTitle, :title, :releaseDate, :posterPath);";
		$id = $movie->getId();
		$originalTitle = $movie->getOriginalTitle();
		$title = $movie->getTitle();
		$releaseDate = $movie->getReleaseDate();
		$posterPath = $movie->getPosterPath();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":originalTitle", $originalTitle, PDO::PARAM_STR);
			$stmt->bindParam(":title", $title, PDO::PARAM_STR);
			$stmt->bindParam(":releaseDate", $releaseDate, PDO::PARAM_STR);
			$stmt->bindParam(":posterPath", $posterPath, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }

	public function delete(Movie $movie){
		$id = $movie->getId();
		$sql = "DELETE FROM movie WHERE id = :id";
		    
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
		$sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie LIMIT 1000";

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
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                $list [] = $movie;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(Movie $movie) {
        $lista = array();
	    $id = $movie->getId();
                
        $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
            WHERE movie.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByOriginalTitle(Movie $movie) {
        $lista = array();
	    $originalTitle = $movie->getOriginalTitle();
                
        $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
            WHERE movie.original_title like :originalTitle";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":originalTitle", $originalTitle, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByTitle(Movie $movie) {
        $lista = array();
	    $title = $movie->getTitle();
                
        $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
            WHERE movie.title like :title";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByReleaseDate(Movie $movie) {
        $lista = array();
	    $releaseDate = $movie->getReleaseDate();
                
        $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
            WHERE movie.release_date like :releaseDate";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":releaseDate", $releaseDate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByPosterPath(Movie $movie) {
        $lista = array();
	    $posterPath = $movie->getPosterPath();
                
        $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
            WHERE movie.poster_path like :posterPath";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":posterPath", $posterPath, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(Movie $movie) {
        
	    $id = $movie->getId();
	    $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
                WHERE movie.id = :id
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
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
                
    public function fillByOriginalTitle(Movie $movie) {
        
	    $originalTitle = $movie->getOriginalTitle();
	    $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
                WHERE movie.original_title = :originalTitle
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":originalTitle", $originalTitle, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
                
    public function fillByTitle(Movie $movie) {
        
	    $title = $movie->getTitle();
	    $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
                WHERE movie.title = :title
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
                
    public function fillByReleaseDate(Movie $movie) {
        
	    $releaseDate = $movie->getReleaseDate();
	    $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
                WHERE movie.release_date = :releaseDate
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":releaseDate", $releaseDate, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
                
    public function fillByPosterPath(Movie $movie) {
        
	    $posterPath = $movie->getPosterPath();
	    $sql = "SELECT movie.id, movie.original_title, movie.title, movie.release_date, movie.poster_path FROM movie
                WHERE movie.poster_path = :posterPath
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":posterPath", $posterPath, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $movie->setId( $row ['id'] );
                $movie->setOriginalTitle( $row ['original_title'] );
                $movie->setTitle( $row ['title'] );
                $movie->setReleaseDate( $row ['release_date'] );
                $movie->setPosterPath( $row ['poster_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
}