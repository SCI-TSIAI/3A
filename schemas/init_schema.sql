-- DROP SCHEMA IF EXISTS gallery;
CREATE SCHEMA IF NOT EXISTS gallery;

-- DROP TABLE IF EXISTS gallery.group
CREATE TABLE IF NOT EXISTS gallery.group
(
  id         SERIAL PRIMARY KEY,
  name       text(64)  NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- DROP TABLE IF EXISTS gallery.permission
CREATE TABLE IF NOT EXISTS gallery.permission
(
  id         SERIAL PRIMARY KEY,
  name       text(64)  NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- DROP TABLE IF EXISTS gallery.group_permission
CREATE TABLE IF NOT EXISTS gallery.group_permission
(
  group_id      BIGINT UNSIGNED NOT NULL,
  permission_id BIGINT UNSIGNED NOT NULL,
  created_at    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (group_id) REFERENCES gallery.group (id),
  FOREIGN KEY (permission_id) REFERENCES gallery.permission (id),
  PRIMARY KEY (group_id, permission_id)
);

-- DROP TABLE IF EXISTS gallery.user
CREATE TABLE IF NOT EXISTS gallery.user
(
  id            SERIAL PRIMARY KEY,
  group_id      BIGINT UNSIGNED NOT NULL,
  username      TEXT(32)        NOT NULL,
  password_hash TEXT            NOT NULL,
  last_login    TIMESTAMP       NOT NULL,
  created_at    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,


  FOREIGN KEY (group_id) REFERENCES gallery.group (id)
);

-- DROP TABLE IF EXISTS gallery.gallery
CREATE TABLE IF NOT EXISTS gallery.gallery
(
  id          SERIAL PRIMARY KEY,
  user_id     BIGINT UNSIGNED NOT NULL,
  name        TEXT(128)       NOT NULL,
  description TEXT(1024),
  last_edited TIMESTAMP       NOT NULL,
  created_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES gallery.user (id)
);

-- DROP TABLE IF EXISTS gallery.image
CREATE TABLE IF NOT EXISTS gallery.image
(
  id          SERIAL PRIMARY KEY,
  gallery_id  BIGINT UNSIGNED NOT NULL,
  reference   TEXT            NOT NULL,
  description TEXT(1024),
  created_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (gallery_id) REFERENCES gallery.gallery (id)
);

-- DROP TABLE IF EXISTS gallery.comment
CREATE TABLE IF NOT EXISTS gallery.comment
(
  id         SERIAL PRIMARY KEY,
  image_id   BIGINT UNSIGNED NOT NULL,
  user_id    BIGINT UNSIGNED NOT NULL,
  title      TEXT(32)        NOT NULL,
  content    TEXT(1024)      NOT NULL,
  created_at TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (image_id) REFERENCES gallery.image (id),
  FOREIGN KEY (user_id) REFERENCES gallery.user (id)
);

-- DROP TABLE IF EXISTS gallery.tag
CREATE TABLE IF NOT EXISTS gallery.tag
(
  id         SERIAL PRIMARY KEY,
  name       TEXT(32)  NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- DROP TABLE IF EXISTS gallery.image_tag
CREATE TABLE IF NOT EXISTS gallery.image_tag
(
  image_id BIGINT UNSIGNED NOT NULL,
  tag_id   BIGINT UNSIGNED NOT NULL,

  FOREIGN KEY (image_id) REFERENCES gallery.image (id),
  FOREIGN KEY (tag_id) REFERENCES gallery.tag (id),
  PRIMARY KEY (image_id, tag_id)
);
