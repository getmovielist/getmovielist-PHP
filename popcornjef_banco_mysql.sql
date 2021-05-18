
CREATE TABLE IF NOT EXISTS comment (
        id  INT NOT NULL AUTO_INCREMENT , 
        PRIMARY KEY (id), 
        id_app_user INT NOT NULL, 
        text VARCHAR(400), 
        id_movie INT NOT NULL
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS favorite_list (
        id  INT NOT NULL AUTO_INCREMENT , 
        PRIMARY KEY (id), 
        id_app_user INT NOT NULL, 
        id_movie INT NOT NULL
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS app_user (
        id  INT NOT NULL AUTO_INCREMENT , 
        PRIMARY KEY (id), 
        name VARCHAR(400), 
        email VARCHAR(400), 
        login VARCHAR(400), 
        password VARCHAR(400), 
        level INT
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS movie (
        id  INT NOT NULL AUTO_INCREMENT , 
        PRIMARY KEY (id), 
        movie_file_path VARCHAR(400), 
        torrent_link VARCHAR(400), 
        subtitle_br_path VARCHAR(400)
)ENGINE = InnoDB;

ALTER TABLE comment
    ADD CONSTRAINT fk_comment_app_user FOREIGN KEY (id_app_user)
    REFERENCES app_user (id);

ALTER TABLE comment
    ADD CONSTRAINT fk_comment_movie FOREIGN KEY (id_movie)
    REFERENCES movie (id);

ALTER TABLE favorite_list
    ADD CONSTRAINT fk_favorite_list_app_user FOREIGN KEY (id_app_user)
    REFERENCES app_user (id);

ALTER TABLE favorite_list
    ADD CONSTRAINT fk_favorite_list_movie FOREIGN KEY (id_movie)
    REFERENCES movie (id);
