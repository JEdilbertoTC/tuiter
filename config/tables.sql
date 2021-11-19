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

UPDATE usuarios
SET role = 1
WHERE id = '';


UPDATE publicaciones
SET comments = comments + 1
WHERE id = '616a4abda22f3';

SELECT u.name, c.message, u.photo, u.email, c.message, c.date
FROM usuarios u
         INNER JOIN comentarios c ON u.id = c.id_user
         INNER JOIN publicaciones p ON c.id_publicacion = p.id
    AND p.id = '616a4abda22f3';


SELECT u.name, c.message, u.photo, u.email, c.message
FROM usuarios u
         INNER JOIN comentarios c ON u.id = c.id_user
         INNER JOIN publicaciones p ON c.id_publicacion = p.id
    AND p.id = '616a4abda22f3'
ORDER BY c.date DESC;


SELECT comments
FROM publicaciones
WHERE id = '616af96ed5f22';


SELECT *
FROM publicaciones p
         INNER JOIN usuarios u ON p.id_user = u.id AND p.id = '616c5f6c2e4b1';

SELECT *
FROM sala_chat
WHERE (id_user1 = '1' AND id_user2 = '2')
   OR (id_user1 = '2' AND id_user2 = '1');


SELECT *
FROM likes
WHERE id_publicacion = '616f7ce74384c'
  AND id_user = '616c451f8b311';
DELETE
FROM mensajes
WHERE id_chat = '617059a0809f6'
  AND id_user = '616ef2f2bf330'
  AND id = '61705bb7ec164';


SELECT *
FROM mensajes m
         INNER JOIN sala_chat sc
                    on m.id_chat = sc.id AND m.id_user = '616c451f8b311' AND sc.id_user1 = '616c451f8b311' OR
                       sc.id_user2 = '616c451f8b311';

DELETE
FROM mensajes m
WHERE m.id_chat = ''
  AND (m.id_user = '' OR m.id_user2 = '')

# DELETE FROM mensajes m WHERE m.id_user IN (SELECT sc.id FROM sala_chat sc WHERE )

DELETE
FROM mensajes
WHERE id = '617091151dd3a';

SELECT u.name
FROM publicaciones p
         INNER JOIN usuarios u ON u.id = p.id_user
ORDER BY RAND()
LIMIT 3