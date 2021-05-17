
CREATE TABLE IF NOT EXISTS movie (
        id  INT NOT NULL AUTO_INCREMENT , 
        PRIMARY KEY (id), 
        movie_file_path VARCHAR(400), 
        torrent_link VARCHAR(400), 
        subtitle_br_path VARCHAR(400)
)ENGINE = InnoDB;
