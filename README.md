# Random-URF-Build
Vistit my project on: http://randomurfbuild.tk/

#Recreate my project
You need a RiotAPI-Key, a MYSQL-Database and a webserver with PHP!
First you add to your Database, two three new tabels:

CREATE TABLE `options` (
  `timestamp` int(11) NOT NULL,
  `primeKey` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`primeKey`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE `GameIdsList` (
  `gameID` int(11) DEFAULT NULL,
  `primeKey` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`primeKey`)
) ENGINE=InnoDB AUTO_INCREMENT=7415 DEFAULT CHARSET=latin1;

CREATE TABLE `champions` (
  `id` int(11) NOT NULL,
  `keyName` mediumtext,
  `name` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

Now insert into options the timestamp, where the updateGameIDs should start reading!
(IMPORTANT NOTE: The timestamp must have to 5-Min-Format like: 1428840000 or 1428326100)

Now open / run the page updateChampions.php, and you have all champions in your database (faster access than RiotAPI) !

We need although cronjobs:
On Unix we add they with crontab -e
*/5 * * * * /usr/bin/php /YOUR_PATH/updateGameIDs.php
0 0 * * * /usr/bin/php /YOUR_PATH/updateChampions.php

And now we are done!
