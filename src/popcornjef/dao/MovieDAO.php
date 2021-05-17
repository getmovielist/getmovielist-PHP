<?php
            
/**
 * Classe feita para manipulação do objeto Movie
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace popcornjef\dao;
use PDO;
use PDOException;
use popcornjef\model\Movie;

class MovieDAO extends DAO {
    
    

            
            
    public function update(Movie $movie)
    {
        $id = $movie->getId();
            
            
        $sql = "UPDATE movie
                SET
                movie_file_path = :movieFilePath,
                torrent_link = :torrentLink,
                subtitle_br_path = :subtitleBrPath
                WHERE movie.id = :id;";
			$movieFilePath = $movie->getMovieFilePath();
			$torrentLink = $movie->getTorrentLink();
			$subtitleBrPath = $movie->getSubtitleBrPath();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":movieFilePath", $movieFilePath, PDO::PARAM_STR);
			$stmt->bindParam(":torrentLink", $torrentLink, PDO::PARAM_STR);
			$stmt->bindParam(":subtitleBrPath", $subtitleBrPath, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(Movie $movie){
        $sql = "INSERT INTO movie(movie_file_path, torrent_link, subtitle_br_path) VALUES (:movieFilePath, :torrentLink, :subtitleBrPath);";
		$movieFilePath = $movie->getMovieFilePath();
		$torrentLink = $movie->getTorrentLink();
		$subtitleBrPath = $movie->getSubtitleBrPath();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":movieFilePath", $movieFilePath, PDO::PARAM_STR);
			$stmt->bindParam(":torrentLink", $torrentLink, PDO::PARAM_STR);
			$stmt->bindParam(":subtitleBrPath", $subtitleBrPath, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(Movie $movie){
        $sql = "INSERT INTO movie(id, movie_file_path, torrent_link, subtitle_br_path) VALUES (:id, :movieFilePath, :torrentLink, :subtitleBrPath);";
		$id = $movie->getId();
		$movieFilePath = $movie->getMovieFilePath();
		$torrentLink = $movie->getTorrentLink();
		$subtitleBrPath = $movie->getSubtitleBrPath();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":movieFilePath", $movieFilePath, PDO::PARAM_STR);
			$stmt->bindParam(":torrentLink", $torrentLink, PDO::PARAM_STR);
			$stmt->bindParam(":subtitleBrPath", $subtitleBrPath, PDO::PARAM_STR);
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
		$sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie LIMIT 1000";

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
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
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
                
        $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
            WHERE movie.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByMovieFilePath(Movie $movie) {
        $lista = array();
	    $movieFilePath = $movie->getMovieFilePath();
                
        $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
            WHERE movie.movie_file_path like :movieFilePath";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":movieFilePath", $movieFilePath, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByTorrentLink(Movie $movie) {
        $lista = array();
	    $torrentLink = $movie->getTorrentLink();
                
        $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
            WHERE movie.torrent_link like :torrentLink";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":torrentLink", $torrentLink, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchBySubtitleBrPath(Movie $movie) {
        $lista = array();
	    $subtitleBrPath = $movie->getSubtitleBrPath();
                
        $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
            WHERE movie.subtitle_br_path like :subtitleBrPath";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":subtitleBrPath", $subtitleBrPath, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $movie = new Movie();
                $movie->setId( $row ['id'] );
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                $lista [] = $movie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(Movie $movie) {
        
	    $id = $movie->getId();
	    $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
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
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
                
    public function fillByMovieFilePath(Movie $movie) {
        
	    $movieFilePath = $movie->getMovieFilePath();
	    $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
                WHERE movie.movie_file_path = :movieFilePath
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":movieFilePath", $movieFilePath, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $movie->setId( $row ['id'] );
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
                
    public function fillByTorrentLink(Movie $movie) {
        
	    $torrentLink = $movie->getTorrentLink();
	    $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
                WHERE movie.torrent_link = :torrentLink
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":torrentLink", $torrentLink, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $movie->setId( $row ['id'] );
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
                
    public function fillBySubtitleBrPath(Movie $movie) {
        
	    $subtitleBrPath = $movie->getSubtitleBrPath();
	    $sql = "SELECT movie.id, movie.movie_file_path, movie.torrent_link, movie.subtitle_br_path FROM movie
                WHERE movie.subtitle_br_path = :subtitleBrPath
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":subtitleBrPath", $subtitleBrPath, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $movie->setId( $row ['id'] );
                $movie->setMovieFilePath( $row ['movie_file_path'] );
                $movie->setTorrentLink( $row ['torrent_link'] );
                $movie->setSubtitleBrPath( $row ['subtitle_br_path'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $movie;
    }
}