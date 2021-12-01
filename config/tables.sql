CREATE DATABASE tuiter;

USE tuiter;

CREATE TABLE usuarios
(
    id        VARCHAR(255),
    name      VARCHAR(255),
    date      DATETIME,
    email     VARCHAR(255) UNIQUE,
    password  VARCHAR(255),
    role      INT,
    photo     VARCHAR(255),
    biography varchar(600),

    PRIMARY KEY (id)
);

CREATE TABLE publicaciones
(
    id       VARCHAR(255),
    info     VARCHAR(255),
    date     DATETIME,
    id_user  VARCHAR(255),
    likes    INT,
    comments INT,

    PRIMARY KEY (id),
    CONSTRAINT fb_pub_usu_id FOREIGN KEY (id_user) REFERENCES usuarios (id) ON DELETE CASCADE
);

CREATE TABLE comentarios
(
    id             VARCHAR(255),
    id_publicacion VARCHAR(255),
    id_user        VARCHAR(255),
    date           DATETIME,
    message        VARCHAR(600),

    PRIMARY KEY (id),
    CONSTRAINT fk_com_pub_id FOREIGN KEY (id_publicacion) REFERENCES publicaciones (id) ON DELETE CASCADE,
    CONSTRAINT fb_com_usu_id FOREIGN KEY (id_user) REFERENCES usuarios (id) ON DELETE CASCADE
);

CREATE TABLE likes
(
    id             VARCHAR(255),
    id_publicacion VARCHAR(255),
    date           DATETIME,
    id_user        VARCHAR(600),

    PRIMARY KEY (id),
    CONSTRAINT fk_likes_pub_id FOREIGN KEY (id_publicacion) REFERENCES publicaciones (id) ON DELETE CASCADE,
    CONSTRAINT fb_likes_usu_id FOREIGN KEY (id_user) REFERENCES usuarios (id) ON DELETE CASCADE
);

CREATE TABLE sala_chat
(
    id       VARCHAR(255),
    id_user1 VARCHAR(255),
    id_user2 VARCHAR(255),

    PRIMARY KEY (id),
    CONSTRAINT fk_sala_chat_user_1 FOREIGN KEY (id_user1) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_sala_chat_user_2 FOREIGN KEY (id_user2) REFERENCES usuarios (id) ON DELETE CASCADE
);

CREATE TABLE mensajes
(
    id      VARCHAR(255),
    id_chat VARCHAR(255),
    mensaje VARCHAR(255),
    date    DATETIME,
    id_user VARCHAR(255),

    CONSTRAINT fk_sala_chat_user FOREIGN KEY (id_chat) REFERENCES sala_chat (id) ON DELETE CASCADE,
    CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES usuarios (id) ON DELETE CASCADE
);