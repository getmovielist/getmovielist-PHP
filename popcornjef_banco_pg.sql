
CREATE TABLE movie (
        id serial NOT NULL, 
        CONSTRAINT pk_movie PRIMARY KEY (id), 
        movie_file_path character varying(400), 
        torrent_link character varying(400), 
        subtitle_br_path character varying(400)
);
