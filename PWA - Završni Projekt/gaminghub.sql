CREATE DATABASE IF NOT EXISTS gaminghub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gaminghub;

DROP TABLE IF EXISTS vijesti;
CREATE TABLE vijesti (
    id INT NOT NULL AUTO_INCREMENT,
    datum VARCHAR(32) NOT NULL,
    naslov VARCHAR(255) NOT NULL,
    sazetak TEXT NOT NULL,
    tekst TEXT NOT NULL,
    slika VARCHAR(255) NOT NULL,
    kategorija VARCHAR(64) NOT NULL,
    arhiva TINYINT(1) NOT NULL DEFAULT 0,
    ocjena VARCHAR(10) DEFAULT NULL,
    PRIMARY KEY (id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva, ocjena) VALUES
('18.06.2026', 'GTA VI ponovno privlači pažnju igrača', 'GTA VI je jedna od igara o kojoj se najviše priča među fanovima otvorenog svijeta.', 'GTA VI je nastavak koji igrači dugo prate i od njega očekuju velik otvoreni svijet, zanimljive likove i puno slobode u igranju.

Najviše se raspravlja o atmosferi grada, vožnji, misijama i načinu na koji će Rockstar iskoristiti modernu tehnologiju. Iako ovdje ne ulazimo u detaljne datume i glasine, jasno je da će igra biti velika tema u gaming zajednici.', 'gta6.jpg', 'vijesti', 0, NULL),
('17.06.2026', 'Minecraft zajednica pokazuje nove kreativne projekte', 'Minecraft i dalje ima aktivnu zajednicu koja stalno radi nove mape, servere i građevine.', 'Minecraft je primjer igre koja ne mora imati kompliciranu priču da bi dugo ostala popularna. Igračima je dovoljno dati alate i prostor, a oni sami stvaraju vlastite svjetove.

Na internetu se često mogu vidjeti veliki gradovi, survival serveri, redstone mehanizmi i mini igre koje su napravili sami igrači. Zbog toga Minecraft i dalje izgleda svježe iako je koncept vrlo jednostavan.', 'minecraft.jpg', 'vijesti', 0, NULL),
('16.06.2026', 'Fortnite ostaje među najaktivnijim online igrama', 'Fortnite se često mijenja kroz sezone, evente i nove sadržaje koje igrači brzo primijete.', 'Fortnite je zanimljiv jer nije samo battle royale igra, nego i platforma koja se stalno mijenja. Igrači se vraćaju zbog novih modova, skinova, mapa i posebnih događaja.

Takav pristup dobro održava pažnju publike, ali može biti težak za nove igrače jer se sadržaj brzo mijenja. Ipak, Fortnite ostaje važan primjer igre koja se razvija kroz vrijeme.', 'fortnite.jpg', 'vijesti', 0, NULL),
('15.06.2026', 'Cyberpunk 2077: dobra atmosfera i bolji dojam nakon popravaka', 'Cyberpunk 2077 danas ostavlja puno bolji dojam zahvaljujući jačoj atmosferi i stabilnijem iskustvu igranja.', 'Cyberpunk 2077 ima jednu od najzanimljivijih atmosfera među modernim RPG igrama. Night City izgleda veliko, šareno i opasno, a igra se najviše ističe kroz likove, misije i glazbu.

Igra nije savršena, ali nakon brojnih popravaka puno je ugodnija za igranje. Najbolji dio je osjećaj da se nalazite u gradu koji ima svoj stil i pravila.', 'cyberpunk2077.jpg', 'recenzije', 0, '8.5/10'),
('14.06.2026', 'Red Dead Redemption 2 recenzija: sporiji tempo koji se isplati', 'Red Dead Redemption 2 je igra koja traži strpljenje, ali zauzvrat daje jaku priču i odličnu atmosferu.', 'Red Dead Redemption 2 nije igra za svakoga jer ima sporiji tempo i puno detalja. Upravo zbog toga mnogima djeluje uvjerljivo, kao pravi svijet u kojem svaki mali trenutak ima svoju težinu.

Najveće prednosti su priča, likovi, priroda i osjećaj putovanja. Igra najbolje funkcionira kada joj se pristupi polako, bez žurbe od misije do misije.', 'rdr2.jpg', 'recenzije', 0, '10/10'),
('13.06.2026', 'Elden Ring recenzija: težak izazov koji nagrađuje istraživanje', 'Elden Ring je zahtjevna igra, ali uspješno motivira igrača da stalno istražuje i pokušava ponovno.', 'Elden Ring je poznat po visokoj težini, ali nije težak samo radi težine. Igrač stalno uči iz pogrešaka, pronalazi novu opremu i otkriva područja koja ranije nije primijetio.

Otvoreni svijet daje puno slobode, pa se igrač može maknuti od preteškog protivnika i vratiti se kasnije. Zbog toga igra ima dobar osjećaj napretka.', 'elden-ring.jpg', 'recenzije', 0, '9.5/10'),
('12.06.2026', 'Što očekujemo od budućih Minecraft nadogradnji', 'Buduće Minecraft nadogradnje mogle bi dodatno proširiti istraživanje, gradnju i preživljavanje.', 'Kod Minecrafta je zanimljivo to što i male promjene mogu jako utjecati na način igranja. Novi blokovi, životinje ili biomi odmah daju igračima dodatne ideje za gradnju i istraživanje.

Najviše bi koristile nadogradnje koje potiču kreativnost, ali ne kompliciraju osnovnu jednostavnost igre. To je razlog zbog kojeg Minecraft i dalje dobro funkcionira za različite tipove igrača.', 'minecraft.jpg', 'najave', 0, NULL),
('11.06.2026', 'GTA VI: najviše želja igrača za otvoreni svijet', 'Igrači od GTA VI najviše očekuju uvjerljiv grad, bolju vožnju i zanimljive sporedne aktivnosti.', 'Kod GTA serijala otvoreni svijet je najvažniji dio iskustva. Zato se od GTA VI očekuje grad koji nije samo velik, nego i zabavan za istraživanje.

Fanovi često spominju bolje ponašanje prometa, više aktivnosti izvan glavne priče i bolji osjećaj svakodnevnog života u gradu. Takvi detalji mogu napraviti veliku razliku u igri otvorenog svijeta.', 'gta6.jpg', 'najave', 0, NULL),
('10.06.2026', 'The Witcher 4: što fanovi očekuju od novog nastavka', 'Od novog Witcher nastavka fanovi očekuju snažne likove, moralne odluke i zanimljiv fantasy svijet.', 'The Witcher serijal najpoznatiji je po pričama, likovima i odlukama koje često nemaju potpuno dobar ili loš izbor. To je nešto što bi fanovi voljeli vidjeti i u novom nastavku.

Najvažnije je da svijet bude zanimljiv za istraživanje i da sporedni zadaci ne djeluju kao običan dodatak. Upravo su takvi zadaci ranije bili jedan od najjačih dijelova serijala.', 'witcher4.jpg', 'najave', 0, NULL);

DROP TABLE IF EXISTS korisnik;
CREATE TABLE korisnik (
    id INT NOT NULL AUTO_INCREMENT,
    ime VARCHAR(32) NOT NULL,
    prezime VARCHAR(32) NOT NULL,
    korisnicko_ime VARCHAR(32) NOT NULL UNIQUE,
    lozinka VARCHAR(255) NOT NULL,
    razina INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES
('Admin', 'Korisnik', 'admin', '$2y$12$a7eqP8CtRLJBehamz7f4lOllnFjHc5XTNywvJI8MAZECB8C1rFP1K', 1),
('Obican', 'Korisnik', 'student', '$2y$12$wu/Ojmi07UoLHOcR7z71iORAokSbedLmrHRcv8P7Mg0YmfPX5C8/y', 0);
