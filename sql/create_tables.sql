CREATE TABLE Kayttaja(
	kayttajaId SERIAL PRIMARY KEY,
	nimi varchar(30) NOT NULL UNIQUE,
	liittymispaiva timestamp,
	salasana varchar(50) NOT NULL
);

CREATE TABLE Keskustelualue(
	keskustelualueId SERIAL PRIMARY KEY,
	nimi varchar(40) NOT NULL
);

CREATE TABLE Tagi(
	tagiId SERIAL PRIMARY KEY,
	nimi varchar(10) NOT NULL
);

CREATE TABLE Viesti(
	viestiId SERIAL PRIMARY KEY,
	sisalto varchar(300),
	lahetysaika timestamp,
	kirjoittajaId INTEGER REFERENCES Kayttaja(kayttajaId),
	keskustelualueId INTEGER REFERENCES Keskustelualue(keskustelualueId)
);

CREATE TABLE Tagays(
	viestiId INTEGER REFERENCES Viesti(viestiId),
	tagiId INTEGER REFERENCES Tagi(tagiId)
);