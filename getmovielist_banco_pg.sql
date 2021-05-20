
CREATE TABLE movie_file (
        id serial NOT NULL, 
        CONSTRAINT pk_movie_file PRIMARY KEY (id), 
        id_movie integer NOT NULL, 
        file_path character varying(400)
);

CREATE TABLE torrent_movie (
        id serial NOT NULL, 
        CONSTRAINT pk_torrent_movie PRIMARY KEY (id), 
        link character varying(400), 
        id_movie_file integer NOT NULL
);

CREATE TABLE subtitle (
        id serial NOT NULL, 
        CONSTRAINT pk_subtitle PRIMARY KEY (id), 
        label character varying(400), 
        file_path character varying(400), 
        id_movie_file integer NOT NULL, 
        lang character varying(400)
);

CREATE TABLE comment (
        id serial NOT NULL, 
        CONSTRAINT pk_comment PRIMARY KEY (id), 
        id_app_user integer NOT NULL, 
        text character varying(400), 
        id_movie integer NOT NULL
);

CREATE TABLE favorite_list (
        id serial NOT NULL, 
        CONSTRAINT pk_favorite_list PRIMARY KEY (id), 
        id_app_user integer NOT NULL, 
        id_movie integer NOT NULL
);

CREATE TABLE app_user (
        id serial NOT NULL, 
        CONSTRAINT pk_app_user PRIMARY KEY (id), 
        name character varying(400), 
        email character varying(400), 
        login character varying(400), 
        password character varying(400), 
        level integer
);

CREATE TABLE movie (
        id serial NOT NULL, 
        CONSTRAINT pk_movie PRIMARY KEY (id), 
        original_title character varying(400), 
        title character varying(400), 
        release_date date, 
        poster_path character varying(400)
);


ALTER TABLE movie_file 
    ADD CONSTRAINT fk_movie_file_movie FOREIGN KEY (id_movie)
    REFERENCES movie (id);


ALTER TABLE torrent_movie 
    ADD CONSTRAINT fk_torrent_movie_movie_file FOREIGN KEY (id_movie_file)
    REFERENCES movie_file (id);


ALTER TABLE subtitle 
    ADD CONSTRAINT fk_subtitle_movie_file FOREIGN KEY (id_movie_file)
    REFERENCES movie_file (id);


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
