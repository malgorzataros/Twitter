CREATE TABLE User (
    id INT AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullName VARCHAR(100),
    active TINYINT DEFAULT 1,
    PRIMARY KEY (id)
);

CREATE TABLE Twitts (
    



);