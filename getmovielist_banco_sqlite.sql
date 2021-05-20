
CREATE TABLE movie_file (
    id INTEGER     PRIMARY KEY AUTOINCREMENT,
    id_movie INTEGER NOT NULL,
    file_path TEXT 
);

CREATE TABLE torrent_movie (
    id INTEGER     PRIMARY KEY AUTOINCREMENT,
    link TEXT ,
    id_movie_file INTEGER NOT NULL
);

CREATE TABLE subtitle (
    id INTEGER     PRIMARY KEY AUTOINCREMENT,
    label TEXT ,
    file_path TEXT ,
    id_movie_file INTEGER NOT NULL
);

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
    original_title TEXT ,
    title TEXT ,
    release_date TEXT ,
    poster_path TEXT 
);
