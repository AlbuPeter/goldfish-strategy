
📌 Projekt neve: Goldfish Strategy

👨‍💻 Készítette: Albu Péter

🎯 Cél
Ez egy hobbi projekt, amely lehetővé teszi a felhasználók számára, hogy nyomon kövessék kriptó portfóliójuk teljes és befektetett értékét.
Nem pénzügyi tanácsadásra szolgál – demonstrációs és oktatási célból készült, példa adatokkal.

⚠️ Jogi nyilatkozat
❗ Ez a projekt nem pénzügyi tanácsadás.
A megjelenített adatok kizárólag példa adatokon alapulnak.
Az eszköz nem garantál pontosságot a valós árfolyamok vagy pénzügyi számítások terén.

🧩 Funkciók
- Kriptó portfólió értékének követése (USDC-ben)
- Történelmi portfólió diagram
- Coin árfolyamok lekérése a CoinGecko API-n keresztül
- Teljes vagyon és befektetett összeg megjelenítése
- Többnyelvű felhasználói felület (🇬🇧 🇭🇺 🇩🇪 🇫🇷)

🌐 Többnyelvűség
Az oldal 4 nyelven érhető el:
- 🇭🇺 Magyar
- 🇬🇧 Angol (alapértelmezett)
- 🇩🇪 Német
- 🇫🇷 Francia

A nyelvváltás JavaScript és data-translate attribútumok segítségével működik.

🛠️ Telepítés és használat

1. XAMPP telepítése
- Telepítsd és indítsd el az Apache és MySQL szervereket

2. Projekt elhelyezése
- Másold a projekt mappát a htdocs könyvtárba, pl.: C:\xampp\htdocs\

3. Adatbázis importálása
- Nyisd meg: http://localhost/phpmyadmin
- Hozz létre egy új adatbázist 'goldfish-strategy' néven
- Importáld a 'goldfish-strategy.sql' fájlt

4. Árak beállítása
- Győződj meg róla, hogy az api/get-prices.php fájl a CoinGecko-tól hozza az aktuális árakat

5. Oldal megnyitása
- Böngészőben: http://localhost/goldfish-strategy/

✅ Használat
- A portfólió automatikusan frissül
- A diagram az időbeli teljesítményt mutatja
- A nyelvek válthatók az oldalon
- Ajánlott napi frissítés (automatizálható)

🔐 Admin hozzáférés
- A portfólió adatai beírhatók az admin felületen keresztül
- Belépéshez használd:
  - Felhasználónév: `admin`
  - Jelszó: `admin`

🚀 További fejlesztési lehetőségek
- Több felhasználós rendszer (minden felhasználónak saját portfólió)
- Emailes értesítések a portfólió változásairól
- Több token
- Automatizált árfrissítés cron job segítségével
