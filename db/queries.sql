INSERT INTO
Users (firstName, lastName, email, postal, password)
VALUES
("Chris", "McDonald", "chris@christophermcdonald.me", "N0B2K0", "123456789012345678901234567890123456789012345678901234567890");


INSERT INTO
Reviews (userId, spaceId, coffee, rating, wifi)
VALUES
(1,1,1,5,5, "WOW! AMAZING!");

INSERT INTO
SpaceImages (reviewId, alt, imgLink)
VALUES
(1, "Coffee Shop Picture", "https://developers.google.com/speed/webp/gallery1");

SELECT s.id, s.name, s.address, s.city, s.postal, count(r.coffee) as coffeeCount, avg(r.rating) as avgRate, avg(r.wifi) as avgWifi FROM Spaces s JOIN Reviews r ON s.id = r.spaceId GROUP BY r.id;

SELECT si.* from SpaceImages si JOIN Reviews r ON si.reviewId = r.id JOIN Spaces s ON s.id = r.spaceId WHERE s.id = 1 LIMIT 1;
