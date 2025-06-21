# URL-Shortener

URL-Shortener ist eine Web-App, mit der man URLs kürzen kann. Der User kann einfach einen beliebigen langen Link eingeben, und dieser wird blitzschnell gekürzt. Um die App nutzen zu können, müssen sich die Nutzer erstmal registrieren (kostenlos).

# Voraussetzungen
Docker v. 28.2.2 oder höher muss bereits vorhanden sein, damit die Docker Container gebaut und gestartet werden können. 

# Installation und Ausführung

1. Den Github Repository lokal klonen:
   ````
   ```
   git clone https://github.com/Basil902/URL-Shortener.git
   ```
   ````
   
3. Wechsle zu dem Projekt Root-Verzeichnis, bevor du Dockerbefehle ausführst;
4. Docker Container bauen & starten mit dem Befehl:
   ````
   ```
   docker compose build -d --build
   ```
   ````
6. Warten bis die Container laufen, dies kann eine Weile dauern;
7. Wichtig: sobald die Container laufen, erstmal die Migrationen in Laravel manuell ausführen, damit die Tabellen erstellt werden:
   ````
   ```
   docker exec -i cuser-service php artisan migrate
   ```
   ````
9. Die Webseite aufrufen unter "localhost/home". Man braucht keine Portnummer anzugeben;
10. Um die Container zu stoppen, folgendem Befehl ausführen:
    ````
    ```
    docker compose down    # -v verwenden, um Volumes zu löschen
    ```
    ````
# Dienste
NGINX (Reverse Proxy / Gateway), läuft auf Port 80: http://localhost:80
Backend / API Endpunkte:
  - shorten_service: Port 5001
  - redirect_service: Port 5002
  - user_service / Frontend (BFF): Port 9000
Der User Service ist ebenfalls für das Rendering der Blade Templates zuständig.

Datenbanken:
  - user_service: MySQL, Port 3306
  - shorten_service: MongoDB, Port 27017
