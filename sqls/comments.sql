CREATE TABLE comments (
id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
article_id INT NOT NULL,
user_id INT NOT NULL,
body TEXT DEFAULT NULL,
published tinyint(1) DEFAULT 0,
created datetime DEFAULT NULL,
modified datetime DEFAULT NULL,
KEY article_key (article_id),
FOREIGN KEY article_key (article_id) REFERENCES articles (id)
)ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4;