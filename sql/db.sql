
-- Platform: erica

CREATE DATABASE IF NOT EXISTS DWI
    CHARACTER SET = utf8;

USE DWI;

CREATE TABLE IF NOT EXISTS Gallery (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    title varchar(250) NOT NULL,
    subtitle varchar(250) NOT NULL,
    description varchar(5000) NOT NULL,
    date datetime NOT NULL,
    isActive tinyint(1) NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id)
) COMMENT="Contains Gallery";

CREATE TABLE IF NOT EXISTS GalleryView (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    galleryId int UNSIGNED NOT NULL,
    views int UNSIGNED NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id),
    UNIQUE KEY (galleryId),
    FOREIGN KEY (galleryId) REFERENCES Gallery(id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT="Contains gallery views";

CREATE TABLE IF NOT EXISTS Tag (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL,
    description varchar(250) NOT NULL,
    isPrimary tinyint(1) NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id),
    UNIQUE KEY (name)
) COMMENT="Contains tags for galleries etc";

CREATE TABLE IF NOT EXISTS GalleryTag (
    galleryId int UNSIGNED NOT NULL,
    tagId int UNSIGNED NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (galleryId, tagId),
    FOREIGN KEY (galleryId) REFERENCES Gallery(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tagId) REFERENCES Tag(id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT="Maps galleries to tags.";

CREATE TABLE IF NOT EXISTS Image (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    galleryId int UNSIGNED NOT NULL,
    description varchar(250),
    path varchar(250) NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id),
    FOREIGN KEY (galleryId) REFERENCES Gallery(id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT="Used to store image locations and information.";

CREATE TABLE IF NOT EXISTS CoverImage (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    galleryId int UNSIGNED NOT NULL,
    imageId int UNSIGNED NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id),
    UNIQUE KEY (galleryId),
    FOREIGN KEY (galleryId) REFERENCES Gallery(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (imageId) REFERENCES Image(id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT="Used to store the gallery cover image ID";

CREATE TABLE IF NOT EXISTS User (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    username varchar(25) NOT NULL,
    password varchar(128) NOT NULL,
    email varchar(255) NOT NULL,
    isActive boolean NOT NULL,
    lastModified timestamp NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY (username),
    UNIQUE KEY (email)
) COMMENT="Users";

CREATE TABLE IF NOT EXISTS Role (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL,
    role varchar(20) NOT NULL,
    lastModified timestamp NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY (role)
) COMMENT="User roles";

CREATE TABLE IF NOT EXISTS UserRole (
    userId int UNSIGNED NOT NULL,
    roleId int UNSIGNED NOT NULL,
    lastModified timestamp NOT NULL,

    PRIMARY KEY (userId, roleId),
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (roleId) REFERENCES Role(id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT="User roles";
