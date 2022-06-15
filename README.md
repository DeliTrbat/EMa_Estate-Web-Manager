# EMa_Estate-Web-Manager
E necesara o aplicatie Web menita a gestiona eficient tranzactiile imobiliare. Sistemul va permite managementul unor imobile spre vanzare si/sau inchiriere, inclusiv informatii precum descriere, pret, coordonatele locatiei, date de contact, starea cladirii, facilitati oferite, riscuri posibile etc. Pentru localizarea facila, se va recurge la un serviciu de cartografiere (e.g., OpenStreetMap). In plus, se va oferi si posibilitatea atasarii de straturi suplimentare pentru vizualizarea unor informatii de interes -- e.g. diversele tipuri de poluare, nivelul de aglomeratie, numarul de raportari de jafuri, costul mediu de trai, temperatura medie anuala, existenta parcarilor ori altor obiective de interes (i.e. magazine) si altele. Pentru generarea diverselor straturi se poate recurge la date agregate existente in cadrul unor platforme sociale (e.g., Twitter, Facebook). De exemplu, pentru stratul poluare fonica, se pot agrega resurse marcate cu tag-ul "#noise" ori "#smog". Utilizatorii interesati de inchirierea/cumpararea unei locuinte (e.g. apartament, casa, loc de veci etc.) vor putea efectua diverse operatiuni folosind harta pusa la dispozitie: selectarea zonei de interes pentru afisarea optiunilor existente, selectarea diverselor straturi pentru luarea deciziei, filtrare in functie de alte criterii (e.g., pret, suprafata, facilitati). Funcționalitatea va fi expusa si sub forma unui serviciu Web REST/GraphQL. Optional, se poate utiliza Geolocation API pentru furnizarea de imobile aflate in vecinatatea utilizatorului.

Design: https://www.figma.com/file/MgwuSLcZmdNURq57CIeqev/Page?node-id=0%3A1


Start server:
```bash
cd public
php -c ../php.ini -S localhost:8000
```


Compile typescript:
```bash
npx tsc -w
```

Compile for public;

```bash
cd ../ema-compiler
npx gulp development
```
