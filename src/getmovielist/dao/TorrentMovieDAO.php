<?php
            
/**
 * Classe feita para manipulação do objeto TorrentMovie
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace getmovielist\dao;
use PDO;
use PDOException;
use getmovielist\model\TorrentMovie;

class TorrentMovieDAO extends DAO {
    
    

            
            
    public function update(TorrentMovie $torrentMovie)
    {
        $id = $torrentMovie->getId();
            
            
        $sql = "UPDATE torrent_movie
                SET
                link = :link
                WHERE torrent_movie.id = :id;";
			$link = $torrentMovie->getLink();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":link", $link, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(TorrentMovie $torrentMovie){
        $sql = "INSERT INTO torrent_movie(link, id_movie_file) VALUES (:link, :movieFile);";
		$link = $torrentMovie->getLink();
		$movieFile = $torrentMovie->getMovieFile()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":link", $link, PDO::PARAM_STR);
			$stmt->bindParam(":movieFile", $movieFile, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(TorrentMovie $torrentMovie){
        $sql = "INSERT INTO torrent_movie(id, link, id_movie_file) VALUES (:id, :link, :movieFile);";
		$id = $torrentMovie->getId();
		$link = $torrentMovie->getLink();
		$movieFile = $torrentMovie->getMovieFile()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":link", $link, PDO::PARAM_STR);
			$stmt->bindParam(":movieFile", $movieFile, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }

	public function delete(TorrentMovie $torrentMovie){
		$id = $torrentMovie->getId();
		$sql = "DELETE FROM torrent_movie WHERE id = :id";
		    
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
		$sql = "SELECT torrent_movie.id, torrent_movie.link, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM torrent_movie INNER JOIN movie_file as movie_file ON movie_file.id = torrent_movie.id_movie_file LIMIT 1000";

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
		        $torrentMovie = new TorrentMovie();
                $torrentMovie->setId( $row ['id'] );
                $torrentMovie->setLink( $row ['link'] );
                $torrentMovie->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $torrentMovie->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $list [] = $torrentMovie;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(TorrentMovie $torrentMovie) {
        $lista = array();
	    $id = $torrentMovie->getId();
                
        $sql = "SELECT torrent_movie.id, torrent_movie.link, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM torrent_movie INNER JOIN movie_file as movie_file ON movie_file.id = torrent_movie.id_movie_file
            WHERE torrent_movie.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $torrentMovie = new TorrentMovie();
                $torrentMovie->setId( $row ['id'] );
                $torrentMovie->setLink( $row ['link'] );
                $torrentMovie->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $torrentMovie->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $torrentMovie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByLink(TorrentMovie $torrentMovie) {
        $lista = array();
	    $link = $torrentMovie->getLink();
                
        $sql = "SELECT torrent_movie.id, torrent_movie.link, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM torrent_movie INNER JOIN movie_file as movie_file ON movie_file.id = torrent_movie.id_movie_file
            WHERE torrent_movie.link like :link";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":link", $link, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $torrentMovie = new TorrentMovie();
                $torrentMovie->setId( $row ['id'] );
                $torrentMovie->setLink( $row ['link'] );
                $torrentMovie->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $torrentMovie->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $torrentMovie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByMovieFile(TorrentMovie $torrentMovie) {
        $lista = array();
	    $movieFile = $torrentMovie->getMovieFile()->getId();
                
        $sql = "SELECT torrent_movie.id, torrent_movie.link, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM torrent_movie INNER JOIN movie_file as movie_file ON movie_file.id = torrent_movie.id_movie_file
            WHERE torrent_movie.id_movie_file = :movieFile";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":movieFile", $movieFile, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $torrentMovie = new TorrentMovie();
                $torrentMovie->setId( $row ['id'] );
                $torrentMovie->setLink( $row ['link'] );
                $torrentMovie->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $torrentMovie->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                $lista [] = $torrentMovie;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(TorrentMovie $torrentMovie) {
        
	    $id = $torrentMovie->getId();
	    $sql = "SELECT torrent_movie.id, torrent_movie.link, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM torrent_movie INNER JOIN movie_file as movie_file ON movie_file.id = torrent_movie.id_movie_file
                WHERE torrent_movie.id = :id
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
                $torrentMovie->setId( $row ['id'] );
                $torrentMovie->setLink( $row ['link'] );
                $torrentMovie->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $torrentMovie->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $torrentMovie;
    }
                
    public function fillByLink(TorrentMovie $torrentMovie) {
        
	    $link = $torrentMovie->getLink();
	    $sql = "SELECT torrent_movie.id, torrent_movie.link, movie_file.id as id_movie_file_movie_file, movie_file.file_path as file_path_movie_file_movie_file FROM torrent_movie INNER JOIN movie_file as movie_file ON movie_file.id = torrent_movie.id_movie_file
                WHERE torrent_movie.link = :link
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":link", $link, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $torrentMovie->setId( $row ['id'] );
                $torrentMovie->setLink( $row ['link'] );
                $torrentMovie->getMovieFile()->setId( $row ['id_movie_file_movie_file'] );
                $torrentMovie->getMovieFile()->setFilePath( $row ['file_path_movie_file_movie_file'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $torrentMovie;
    }
}