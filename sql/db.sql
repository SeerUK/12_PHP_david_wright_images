
-- Platform: erica

CREATE DATABASE IF NOT EXISTS DWI
    CHARACTER SET = utf8;

USE DWI;

CREATE TABLE IF NOT EXISTS Gallery (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    subtitle varchar(255) NOT NULL,
    description varchar(5000) NOT NULL,
    date datetime NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id)
) COMMENT="Contains Gallery";

CREATE TABLE IF NOT EXISTS Tag (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL,
    description varchar(250) NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id)
) COMMENT="Contains tags for galleries etc";

CREATE TABLE IF NOT EXISTS GalleryTagMap (
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
    FOREIGN KEY (galleryId) REFERENCES Gallery(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (imageId) REFERENCES Image(id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT="Used to store the gallery cover image ID";
