CREATE TABLE Kayttaja(
	kayttajaid SERIAL PRIMARY KEY,
	nimi varchar(30) NOT NULL UNIQUE,
	liittymispaiva timestamp,
	lempivari varchar(20),
	esittelyteksti varchar(300),
	salasana varchar(50) NOT NULL
);

CREATE TABLE Keskustelualue(
	keskustelualueId SERIAL PRIMARY KEY,
	nimi varchar(40) NOT NULL
);

CREATE TABLE Tagi(
	tagiid SERIAL PRIMARY KEY,
	nimi varchar(10) NOT NULL
);

CREATE TABLE Viesti(
	viestiid SERIAL PRIMARY KEY,
	sisalto varchar(300),
	lahetysaika timestamp,
	kirjoittajaid INTEGER REFERENCES Kayttaja(kayttajaId),
	keskustelualueid INTEGER REFERENCES Keskustelualue(keskustelualueId)
);

CREATE TABLE Tagays(
	viestiid INTEGER REFERENCES Viesti(viestiid),
	tagiid INTEGER REFERENCES Tagi(tagiid)
);