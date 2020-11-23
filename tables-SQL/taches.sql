DROP TABLE IF EXISTS intervenant;

CREATE TABLE intervenant (
   code int(11) DEFAULT '0' NOT NULL,
   prenom varchar(20) NOT NULL,
   nom varchar(20) NOT NULL,
   password varchar(32),
   PRIMARY KEY (code)
);

INSERT INTO intervenant VALUES( '1', 'Florian', 'Robache', '');
INSERT INTO intervenant VALUES( '2', 'Steve', 'Jobs', '');
INSERT INTO intervenant VALUES( '3', 'Jeff', 'Bezos', '');
INSERT INTO intervenant VALUES( '4', 'Bill', 'Gates', '');
INSERT INTO intervenant VALUES( '5', 'Andy', 'Raconte', '');


DROP TABLE IF EXISTS sid;

CREATE TABLE sid (
   sid char(8) NOT NULL,
   demandeur int(11),
   dern_maj datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   PRIMARY KEY (sid)
);


DROP TABLE IF EXISTS tache;

CREATE TABLE tache (
   numero int(11) auto_increment,
   date_demande varchar(20) NOT NULL,
   objet varchar(255) NOT NULL,
   echeance varchar(20),
   date_fin varchar(20),
   fini char(1) NOT NULL,
   intervenant int(11) DEFAULT '0' NOT NULL,
   action varchar(255),
   priorite int(11) DEFAULT '0' NOT NULL,
   objet_court varchar(30) NOT NULL,
   demandeur int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (numero),
   KEY intervenant (intervenant)
);
