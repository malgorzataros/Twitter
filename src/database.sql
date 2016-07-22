CREATE TABLE User (
    id INT AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullName VARCHAR(100),
    active TINYINT DEFAULT 1,
    PRIMARY KEY (id)
);

CREATE TABLE Tweet (
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    text VARCHAR(160) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES User(id)
);

CREATE TABLE Comment (
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    creation_date DATATIME NOT NULL,
    text VARCHAR(160),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES User(id),
    FOREIGN KEY (post_id) REFERENCES Tweet(id)
    
)

CREATE TABLE Message (
    id INT AUTO_INCREMENT,
    sender_id INT NOT NULL,
    receiver_id INT NULL,
    message VARCHAR(160) NOT NULL,
    message_date DATETIME NOT NULL,
    message_status TINYINT DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (sender_id) REFERENCES User(id),
    FOREIGN KEY (receiver_id) REFERENCES User(id)
)