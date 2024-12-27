-- Active: 1733760231294@@127.0.0.1@3306@fut_champions
CREATE DATABASE fut_champions_scripts;

create table clubs (
    club_id int PRIMARY KEY AUTO_INCREMENT,
    club_name VARCHAR (50),
    club_logo VARCHAR(50)
);

create table nationalities (
    nationality_id in PRIMARY KEY AUTO_INCREMENT,
    nationality_name VARCHAR (50),
    nationality_logo VARCHAR(50)
)

CREATE Table players (
    player_id int PRIMARY KEY AUTO_INCREMENT ,
    name VARCHAR(50),
    photo VARCHAR(100),
    position ENUM("gk","rb","rcb","lcb","lb","rm","cm","lm","rw","st","lw"),
    nationality_id int,
    club_id int, 
    rating int,
    
    Foreign Key (nationality_id) REFERENCES nationalities (nationality_id),
    Foreign Key (club_id) REFERENCES clubs (club_id)
);

--the following query is to make the foreign key has constraint "on delete cascade" 
ALTER TABLE player_stats
ADD CONSTRAINT fk_player_stats
FOREIGN KEY (player_id)
REFERENCES players(player_id)
ON DELETE CASCADE; 

SELECT* FROM player_stats

INSERT into players (name,photo,position,nationality_id,club_id,rating)
VALUES("ilyass","https://cdn.sofifa.net/players/212/198/25_120.png","st",1,1,88);

CREATE Table goalkeeper_stats(
    player_id int PRIMARY KEY,
    diving int,
    handling int,
    kicking int,
    reflexes int,
    speed int,
    positioning int,
    Foreign Key (player_id) REFERENCES players (player_id) ON DELETE CASCADE
);


CREATE Table player_stats(
    player_id int PRIMARY KEY,
    pace int,
    shooting int,
    passing int,
    dribling int,
    defending int,
    physical int,
    Foreign Key (player_id) REFERENCES players (player_id) ON DELETE CASCADE
);

DROP Table players;

INSERT into nationalities (nationality_name, nationality_logo)
VALUES
("Argentina", "https://cdn.sofifa.net/flags/ar.png"),
("Portugal","https://cdn.sofifa.net/players/020/801/25_120.png"),
("Belgium","https://cdn.sofifa.net/flags/be.png"),
("France","https://cdn.sofifa.net/flags/fr.png"),
("Germany","https://cdn.sofifa.net/flags/de.png"),
("Brazil","https://cdn.sofifa.net/flags/br.png"),
("Morocco","https://cdn.sofifa.net/flags/ma.png");

Insert into clubs (club_name, club_logo)
VALUES
("Inter Miami","https://cdn.sofifa.net/meta/team/239235/120.png"),
("Al Nasser", "https://cdn.sofifa.net/meta/team/2506/120.png"),
("Manchester City","https://cdn.sofifa.net/players/239/085/25_120.png"),
("Real Madrid", "https://cdn.sofifa.net/meta/team/3468/120.png"),
("Liverpool", "https://cdn.sofifa.net/meta/team/8/120.png"),
("Bayern Munich","https://cdn.sofifa.net/meta/team/503/120.png"),
("Manchester United","https://cdn.sofifa.net/meta/team/14/120.png");

SELECT *,
          nationality_name,
          nationality_logo,
          club_logo
          FROM players
          join nationalities on players.nationality_id = nationalities.nationality_id
          join clubs on players.club_id = clubs.club_id


-- THE FOLLOWING QUERY IS TO BRING THE CLUB WITH HIGHEST TOTAL OF PLAYERS

SELECT  clb.club_name as club_name, players.club_id , COUNT(players.club_id) as totalplayers
FROM clubs clb
JOIN players ON players.club_id = clb.club_id
GROUP BY players.club_id 
ORDER BY totalplayers DESC
LIMIT 1




