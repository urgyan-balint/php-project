# PHP Bejelentkező Rendszer Dokumentáció

## Projekt Áttekintés
Ez a projekt egy egyszerű bejelentkező rendszert valósít meg PHP nyelven. A rendszer titkosított jelszavakat használ, amelyeket a `password.txt` fájlban tárol. A felhasználók bejelentkezhetnek e-mail cím és jelszó párossal, majd a rendszer egy adatbázisból lekéri a felhasználóhoz tartozó "titkos színt", amit a háttérszínként jelenít meg.

---

## Fájlstruktúra
1. **index.php**  
   - Bejelentkező űrlapot jelenít meg.
   - A felhasználó e-mail címet és jelszót adhat meg.
   - A form adatokat POST kéréssel küldi az `ellenorzes.php`-nak.

2. **teszt.php**  
   - Dekódolja a `password.txt` tartalmát a `decode_password` függvénnyel.
   - Kiírja a dekódolt felhasználóneveket és jelszavakat tesztelési célból.

3. **ellenorzes.php**  
   - Feldolgozza a bejelentkezési adatokat.
   - Dekódolja a titkosított jelszavakat, ellenőrzi a hitelesítést.
   - Adatbázisból lekéri a felhasználóhoz tartozó színt.
   - Sikeres bejelentkezés esetén egy színes üdvözlő oldalt jelenít meg.

4. **password.txt**  
   - Titkosított felhasználói adatokat tartalmaz (formátum: `titkosított_felhasználónév*jelszó`).

---

## Függőségek
- **PHP 7.4 vagy újabb** (a kódban használt szintaxis miatt).
- **MySQL adatbázis** a következő konfigurációval:
  - Szerver: `localhost`
  - Felhasználónév: `root`
  - Jelszó: *üres* (nincs beállítva)
  - Adatbázis neve: `adatok`
  - Tábla neve: `tabla`  
    A tábla struktúrája:  
    ```sql
    CREATE TABLE tabla (
        Username VARCHAR(255) PRIMARY KEY,
        Titkos VARCHAR(50) NOT NULL
    );
    ```

---

## Telepítés és Futtatás
1. Hozd létre az adatbázist és a táblát a fenti SQL paranccsal.
2. Töltsd fel a `tabla` táblát példaadatokkal:
   ```sql
   INSERT INTO tabla (Username, Titkos) VALUES
   ('user1@example.com', 'piros'),
   ('user2@example.com', 'zold');
