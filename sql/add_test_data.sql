INSERT INTO Kayttaja (nimi, liittymispaiva, salasana, lempivari, esittelyteksti, admin) VALUES ('Abraham Lincoln', '2011-05-16 15:36:38', 'straitpimpin', 'Punainen', 'Olen hasu henkilö', TRUE);

INSERT INTO Kayttaja (nimi, liittymispaiva, salasana, lempivari, esittelyteksti, admin) VALUES ('afsasfdgsfsdg', '2012-03-17 11:11:11', 'asd', 'Vihreä', 'Tykkään tietokannoista, ja varsinkin niihin liittyvistä harjoitustöistä', FALSE);

INSERT INTO Keskustelualue (nimi) VALUES ('Miten?');
INSERT INTO Keskustelualue (nimi) VALUES ('Miksi?');

INSERT INTO Tagi (nimi) VALUES ('Asiaton');
INSERT INTO Tagi (nimi) VALUES ('Asd');

INSERT INTO Viesti (sisalto, lahetysaika, kirjoittajaid, keskustelualueid) VALUES ('Apua olen tyhmä paksukainen', '2015-07-29 12:12:12', 1, 1);
INSERT INTO Viesti (sisalto, lahetysaika, kirjoittajaid, keskustelualueid) VALUES ('En tiedä mitään', '2015-08-29 13:12:12', 1, 2);

INSERT INTO Tagays (viestiid, tagiid) VALUES (1, 1);
