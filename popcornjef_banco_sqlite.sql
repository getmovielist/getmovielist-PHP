
CREATE TABLE comment (
    id INTEGER     PRIMARY KEY AUTOINCREMENT,
    id_app_user INTEGER NOT NULL,
    text TEXT ,
    id_movie INTEGER NOT NULL
);

CREATE TABLE favorite_list (
    id INTEGER     PRIMARY KEY AUTOINCREMENT,
    id_app_user INTEGER NOT NULL,
    id_movie INTEGER NOT NULL
);

CREATE TABLE app_user (
    id INTEGER     PRIMARY KEY AUTOINCREMENT,
    name TEXT ,
    email TEXT ,
    login TEXT ,
    password TEXT ,
    level INTEGER 
);

CREATE TABLE movie (
    id INTEGER     PRIMARY KEY AUTOINCREMENT,
    movie_file_path TEXT ,
    torrent_link TEXT ,
    subtitle_br_path TEXT 
);
