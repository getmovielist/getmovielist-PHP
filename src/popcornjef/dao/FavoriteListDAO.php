<?php
            
/**
 * Classe feita para manipulação do objeto FavoriteList
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace popcornjef\dao;
use PDO;
use PDOException;
use popcornjef\model\FavoriteList;

class FavoriteListDAO extends DAO {
    
    

            
            
    public function update(FavoriteList $favoriteList)
    {
        $id = $favoriteList->getId();
            
            
        $sql = "UPDATE favorite_list
                SET
                
                WHERE favorite_list.id = :id;";
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(FavoriteList $favoriteList){
        $sql = "INSERT INTO favorite_list(id_app_user, id_movie) VALUES (:appUser, :movie);";
		$appUser = $favoriteList->getAppUser()->getId();
		$movie = $favoriteList->getMovie()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":appUser", $appUser, PDO::PARAM_INT);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(FavoriteList $favoriteList){
        $sql = "INSERT INTO favorite_list(id, id_app_user, id_movie) VALUES (:id, :appUser, :movie);";
		$id = $favoriteList->getId();
		$appUser = $favoriteList->getAppUser()->getId();
		$movie = $favoriteList->getMovie()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":appUser", $appUser, PDO::PARAM_INT);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }

	public function delete(FavoriteList $favoriteList){
		$id = $favoriteList->getId();
		$sql = "DELETE FROM favorite_list WHERE id = :id";
		    
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
		$sql = "SELECT favorite_list.id, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM favorite_list INNER JOIN app_user as app_user ON app_user.id = favorite_list.id_app_user INNER JOIN movie as movie ON movie.id = favorite_list.id_movie LIMIT 1000";

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
		        $favoriteList = new FavoriteList();
                $favoriteList->setId( $row ['id'] );
                $favoriteList->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $favoriteList->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $favoriteList->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $favoriteList->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $favoriteList->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $favoriteList->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $favoriteList->getMovie()->setId( $row ['id_movie_movie'] );
                $favoriteList->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $favoriteList->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $favoriteList->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $list [] = $favoriteList;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(FavoriteList $favoriteList) {
        $lista = array();
	    $id = $favoriteList->getId();
                
        $sql = "SELECT favorite_list.id, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM favorite_list INNER JOIN app_user as app_user ON app_user.id = favorite_list.id_app_user INNER JOIN movie as movie ON movie.id = favorite_list.id_movie
            WHERE favorite_list.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $favoriteList = new FavoriteList();
                $favoriteList->setId( $row ['id'] );
                $favoriteList->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $favoriteList->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $favoriteList->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $favoriteList->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $favoriteList->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $favoriteList->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $favoriteList->getMovie()->setId( $row ['id_movie_movie'] );
                $favoriteList->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $favoriteList->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $favoriteList->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $lista [] = $favoriteList;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByAppUser(FavoriteList $favoriteList) {
        $lista = array();
	    $appUser = $favoriteList->getAppUser()->getId();
                
        $sql = "SELECT favorite_list.id, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM favorite_list INNER JOIN app_user as app_user ON app_user.id = favorite_list.id_app_user INNER JOIN movie as movie ON movie.id = favorite_list.id_movie
            WHERE favorite_list.id_app_user = :appUser";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":appUser", $appUser, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $favoriteList = new FavoriteList();
                $favoriteList->setId( $row ['id'] );
                $favoriteList->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $favoriteList->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $favoriteList->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $favoriteList->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $favoriteList->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $favoriteList->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $favoriteList->getMovie()->setId( $row ['id_movie_movie'] );
                $favoriteList->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $favoriteList->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $favoriteList->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $lista [] = $favoriteList;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByMovie(FavoriteList $favoriteList) {
        $lista = array();
	    $movie = $favoriteList->getMovie()->getId();
                
        $sql = "SELECT favorite_list.id, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM favorite_list INNER JOIN app_user as app_user ON app_user.id = favorite_list.id_app_user INNER JOIN movie as movie ON movie.id = favorite_list.id_movie
            WHERE favorite_list.id_movie = :movie";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $favoriteList = new FavoriteList();
                $favoriteList->setId( $row ['id'] );
                $favoriteList->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $favoriteList->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $favoriteList->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $favoriteList->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $favoriteList->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $favoriteList->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $favoriteList->getMovie()->setId( $row ['id_movie_movie'] );
                $favoriteList->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $favoriteList->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $favoriteList->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $lista [] = $favoriteList;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(FavoriteList $favoriteList) {
        
	    $id = $favoriteList->getId();
	    $sql = "SELECT favorite_list.id, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM favorite_list INNER JOIN app_user as app_user ON app_user.id = favorite_list.id_app_user INNER JOIN movie as movie ON movie.id = favorite_list.id_movie
                WHERE favorite_list.id = :id
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
                $favoriteList->setId( $row ['id'] );
                $favoriteList->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $favoriteList->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $favoriteList->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $favoriteList->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $favoriteList->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $favoriteList->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $favoriteList->getMovie()->setId( $row ['id_movie_movie'] );
                $favoriteList->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $favoriteList->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $favoriteList->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $favoriteList;
    }
}