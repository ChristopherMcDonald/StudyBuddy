CREATE TABLE Users (
    id int NOT NULL AUTO_INCREMENT,
    firstName varchar(20) NOT NULL,
    lastName varchar(20) NOT NULL,
    email varchar(30) UNIQUE,
    postal char(6) NOT NULL,
    password char(60) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Spaces (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL,
    address varchar(30) NOT NULL,
    city varchar(30) NOT NULL,
    province varchar(20) NOT NULL,
    postal char(6) NOT NULL,
    lat DECIMAL(10, 8) DEFAULT -1,
    lng DECIMAL(11, 8) DEFAULT -1,
    PRIMARY KEY (id)
);

CREATE TABLE Reviews (
    id int NOT NULL AUTO_INCREMENT,
    userId int NOT NULL,
    spaceId int NOT NULL,
    coffee boolean NOT NULL,
    rating int NOT NULL,
    wifi int NOT NULL,
    comment varchar(140) NOT NULL,
    visit datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (userId)
        REFERENCES Users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (spaceId)
        REFERENCES Spaces(id)
        ON DELETE CASCADE
);


CREATE TABLE SpaceImages (
    reviewId int NOT NULL,
    imgLink varchar(1024) NOT NULL,
    alt varchar(40) NOT NULL,
    FOREIGN KEY (reviewId)
        REFERENCES Reviews(id)
        ON DELETE CASCADE
);
