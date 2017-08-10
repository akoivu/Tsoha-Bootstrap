INSERT INTO Kayttaja (nimi, liittymispaiva, salasana, lempivari, esittelyteksti) VALUES ('Abraham Lincoln', '2011-05-16 15:36:38', 'straitpimpin', 'Punainen', 'Olen hasu henkilö');
INSERT INTO Kayttaja (nimi, liittymispaiva, salasana, lempivari, esittelyteksti) VALUES ('haloodsgklngdsnk', '2013-04-11 15:36:38', 'salasana', 'Vihreä', 'Olen henkilö, joka nauttii tietokannoista ja kaikista muistakin tärkeistä asioista.');

INSERT INTO Keskustelualue (nimi) VALUES ('Miten?');
INSERT INTO Keskustelualue (nimi) VALUES ('Miksi?');

INSERT INTO Tagi (nimi) VALUES ('Asiaton');
INSERT INTO Tagi (nimi) VALUES ('Asd');

INSERT INTO Viesti (sisalto, lahetysaika, kirjoittajaid, keskustelualueid) VALUES ('En tiedä', '2012-01-11 15:26:38', 1, 1);
INSERT INTO Viesti (sisalto, lahetysaika, kirjoittajaid, keskustelualueid) VALUES ('Apua, olen tyhmä paksukainen', '2000-01-11 00:40:38', 2, 2);
INSERT INTO Viesti (sisalto, lahetysaika, kirjoittajaid, keskustelualueid) VALUES ('En olekaan!!!!', '2000-01-11 00:41:33', 2, 2);

INSERT INTO Tagays (viestiid, tagiid) VALUES (1, 1);