<?php
                
/**
 * Customize sua classe
 *
 */


namespace popcornjef\custom\dao;
use popcornjef\dao\FavoriteListDAO;
use popcornjef\model\FavoriteList;
use PDO;
use PDOException;

class  FavoriteListCustomDAO extends FavoriteListDAO {
    public function fetchByAppUserAndMovie(FavoriteList $favoriteList) {
        $lista = array();
        $movie = $favoriteList->getMovie()->getId();
        $appUser = $favoriteList->getAppUser()->getId();
        
        $sql = "SELECT favorite_list.id, app_user.id as id_app_user_app_user, app_user.name as name_app_user_app_user, app_user.email as email_app_user_app_user, app_user.login as login_app_user_app_user, app_user.password as password_app_user_app_user, app_user.level as level_app_user_app_user, movie.id as id_movie_movie, movie.movie_file_path as movie_file_path_movie_movie, movie.torrent_link as torrent_link_movie_movie, movie.subtitle_br_path as subtitle_br_path_movie_movie FROM favorite_list INNER JOIN app_user as app_user ON app_user.id = favorite_list.id_app_user INNER JOIN movie as movie ON movie.id = favorite_list.id_movie
            WHERE favorite_list.id_app_user = :appUser AND favorite_list.id_movie = :movie";
        
        try {
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":appUser", $appUser, PDO::PARAM_INT);
            $stmt->bindParam(":movie", $movie, PDO::PARAM_INT);
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
                $lista [] = $favoriteList;
                
                
            }
            
        } catch(PDOException $e) {
            echo $e->getMessage();
            
        }
        return $lista;
    }


}