<?php
                
/**
 * Customize sua classe
 *
 */


namespace getmovielist\custom\dao;
use getmovielist\dao\AppUserDAO;
use getmovielist\model\AppUser;
use PDO;
use PDOException;

class  AppUserCustomDAO extends AppUserDAO {
    
    
    public function autentica(AppUser $usuario){
        $login = $usuario->getLogin();
        $password = $usuario->getPassword() ;
        $sql = "SELECT * FROM app_user WHERE login  = :login AND password = :password LIMIT 1";
        
        try {
            
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $usuario->setLogin ( $linha ['login'] );
                $usuario->setId( $linha ['id'] );
                $usuario->setLevel($linha ['level'] );
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
        
        
    }


}