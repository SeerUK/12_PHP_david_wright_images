
-- Platform: erica

CREATE DATABASE IF NOT EXISTS dwrighti
    CHARACTER SET = utf8;


CREATE TABLE Gallery (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description varchar(5000) NOT NULL,
    date datetime NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id)
) COMMENT="Contains Gallery";

CREATE TABLE Tag (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL,
    description varchar(250) NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id)
) COMMENT="Contains tags for galleries etc";

CREATE TABLE GalleryTagMap (
    galleryId int UNSIGNED NOT NULL,
    tagId int UNSIGNED NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (galleryId, tagId),
    FOREIGN KEY (galleryId) REFERENCES Gallery(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tagId) REFERENCES Tag(id) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT="Maps galleries to tags.";

CREATE TABLE GalleryImages (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    description varchar(250),
    path varchar(250) NOT NULL,
    lastModified timestamp,

    PRIMARY KEY (id)
) COMMENT="Used to store image locations and information.";
