<?php
            
/**
 * Classe feita para manipulação do objeto Comment
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 */
     
namespace popcornjef\dao;
use PDO;
use PDOException;
use popcornjef\model\Comment;

class CommentDAO extends DAO {
    
    

            
            
    public function update(Comment $comment)
    {
        $id = $comment->getId();
            
            
        $sql = "UPDATE comment
                SET
                text = :text
                WHERE comment.id = :id;";
			$text = $comment->getText();
            
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":text", $text, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function insert(Comment $comment){
        $sql = "INSERT INTO comment(id_app_user, text, id_movie) VALUES (:appUser, :text, :movie);";
		$appUser = $comment->getAppUser()->getId();
		$text = $comment->getText();
		$movie = $comment->getMovie()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":appUser", $appUser, PDO::PARAM_INT);
			$stmt->bindParam(":text", $text, PDO::PARAM_STR);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function insertWithPK(Comment $comment){
        $sql = "INSERT INTO comment(id, id_app_user, text, id_movie) VALUES (:id, :appUser, :text, :movie);";
		$id = $comment->getId();
		$appUser = $comment->getAppUser()->getId();
		$text = $comment->getText();
		$movie = $comment->getMovie()->getId();
		try {
			$db = $this->getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":appUser", $appUser, PDO::PARAM_INT);
			$stmt->bindParam(":text", $text, PDO::PARAM_STR);
			$stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }

	public function delete(Comment $comment){
		$id = $comment->getId();
		$sql = "DELETE FROM comment WHERE id = :id";
		    
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
		$sql = "SELECT comment.id, comment.text, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM comment INNER JOIN app_user as app_user ON app_user.id = comment.id_app_user INNER JOIN movie as movie ON movie.id = comment.id_movie LIMIT 1000";

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
		        $comment = new Comment();
                $comment->setId( $row ['id'] );
                $comment->setText( $row ['text'] );
                $comment->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $comment->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $comment->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $comment->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $comment->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $comment->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $comment->getMovie()->setId( $row ['id_movie_movie'] );
                $comment->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $comment->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $comment->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $list [] = $comment;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $list;	
    }
        
                
    public function fetchById(Comment $comment) {
        $lista = array();
	    $id = $comment->getId();
                
        $sql = "SELECT comment.id, comment.text, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM comment INNER JOIN app_user as app_user ON app_user.id = comment.id_app_user INNER JOIN movie as movie ON movie.id = comment.id_movie
            WHERE comment.id = :id";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $comment = new Comment();
                $comment->setId( $row ['id'] );
                $comment->setText( $row ['text'] );
                $comment->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $comment->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $comment->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $comment->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $comment->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $comment->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $comment->getMovie()->setId( $row ['id_movie_movie'] );
                $comment->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $comment->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $comment->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $lista [] = $comment;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByAppUser(Comment $comment) {
        $lista = array();
	    $appUser = $comment->getAppUser()->getId();
                
        $sql = "SELECT comment.id, comment.text, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM comment INNER JOIN app_user as app_user ON app_user.id = comment.id_app_user INNER JOIN movie as movie ON movie.id = comment.id_movie
            WHERE comment.id_app_user = :appUser";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":appUser", $appUser, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $comment = new Comment();
                $comment->setId( $row ['id'] );
                $comment->setText( $row ['text'] );
                $comment->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $comment->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $comment->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $comment->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $comment->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $comment->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $comment->getMovie()->setId( $row ['id_movie_movie'] );
                $comment->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $comment->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $comment->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $lista [] = $comment;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByText(Comment $comment) {
        $lista = array();
	    $text = $comment->getText();
                
        $sql = "SELECT comment.id, comment.text, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM comment INNER JOIN app_user as app_user ON app_user.id = comment.id_app_user INNER JOIN movie as movie ON movie.id = comment.id_movie
            WHERE comment.text like :text";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":text", $text, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $comment = new Comment();
                $comment->setId( $row ['id'] );
                $comment->setText( $row ['text'] );
                $comment->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $comment->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $comment->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $comment->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $comment->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $comment->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $comment->getMovie()->setId( $row ['id_movie_movie'] );
                $comment->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $comment->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $comment->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $lista [] = $comment;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fetchByMovie(Comment $comment) {
        $lista = array();
	    $movie = $comment->getMovie()->getId();
                
        $sql = "SELECT comment.id, comment.text, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM comment INNER JOIN app_user as app_user ON app_user.id = comment.id_app_user INNER JOIN movie as movie ON movie.id = comment.id_movie
            WHERE comment.id_movie = :movie";
                
        try {
                
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $row ){
		        $comment = new Comment();
                $comment->setId( $row ['id'] );
                $comment->setText( $row ['text'] );
                $comment->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $comment->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $comment->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $comment->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $comment->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $comment->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $comment->getMovie()->setId( $row ['id_movie_movie'] );
                $comment->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $comment->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $comment->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                $lista [] = $comment;

	
		    }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function fillById(Comment $comment) {
        
	    $id = $comment->getId();
	    $sql = "SELECT comment.id, comment.text, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM comment INNER JOIN app_user as app_user ON app_user.id = comment.id_app_user INNER JOIN movie as movie ON movie.id = comment.id_movie
                WHERE comment.id = :id
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
                $comment->setId( $row ['id'] );
                $comment->setText( $row ['text'] );
                $comment->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $comment->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $comment->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $comment->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $comment->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $comment->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $comment->getMovie()->setId( $row ['id_movie_movie'] );
                $comment->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $comment->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $comment->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $comment;
    }
                
    public function fillByText(Comment $comment) {
        
	    $text = $comment->getText();
	    $sql = "SELECT comment.id, comment.text, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM comment INNER JOIN app_user as app_user ON app_user.id = comment.id_app_user INNER JOIN movie as movie ON movie.id = comment.id_movie
                WHERE comment.text = :text
                 LIMIT 1000";
                
        try {
            $stmt = $this->connection->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->connection->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":text", $text, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $row )
            {
                $comment->setId( $row ['id'] );
                $comment->setText( $row ['text'] );
                $comment->getAppUser()->setId( $row ['id_app_user_app_user'] );
                $comment->getAppUser()->setName( $row ['name_app_user_app_user'] );
                $comment->getAppUser()->setEmail( $row ['email_app_user_app_user'] );
                $comment->getAppUser()->setLogin( $row ['login_app_user_app_user'] );
                $comment->getAppUser()->setPassword( $row ['password_app_user_app_user'] );
                $comment->getAppUser()->setLevel( $row ['level_app_user_app_user'] );
                $comment->getMovie()->setId( $row ['id_movie_movie'] );
                $comment->getMovie()->setMovieFilePath( $row ['movie_file_path_movie_movie'] );
                $comment->getMovie()->setTorrentLink( $row ['torrent_link_movie_movie'] );
                $comment->getMovie()->setSubtitleBrPath( $row ['subtitle_br_path_movie_movie'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $comment;
    }
}