CREATE TABLE Users (
    id int NOT NULL AUTO_INCREMENT,
    firstName varchar(20),
    lastName varchar(20),
    email varchar(30) UNIQUE,
    postal char(6),
    password char(60),
    PRIMARY KEY (id)
);

CREATE TABLE Spaces (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(30),
    address varchar(30),
    city varchar(30),
    postal char(6),
    PRIMARY KEY (id)
);

CREATE TABLE Reviews (
    id int NOT NULL AUTO_INCREMENT,
    userId int,
    spaceId int,
    coffee boolean,
    rating int,
    wifi int,
    comment varchar(140),
    visit datetime,
    PRIMARY KEY (id),
    FOREIGN KEY (userId)
        REFERENCES Users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (spaceId)
        REFERENCES Spaces(id)
        ON DELETE CASCADE
);


CREATE TABLE SpaceImages (
    reviewId int,
    imgLink varchar(1024),
    alt varchar(40),
    FOREIGN KEY (reviewId)
        REFERENCES Reviews(id)
        ON DELETE CASCADE
);
