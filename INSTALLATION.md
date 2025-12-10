# Angebotsanfrage-Seite Installation - Bionic World

## 📋 Übersicht

Diese Angebotsanfrage-Seite enthält:
- ✅ Benutzerdaten-Eingabe (Vorname, Nachname, E-Mail, Telefon, Firma, Position)
- ✅ 9 anklickbare Angebots-Checkboxen mit Icons
- ✅ Kommentarfeld für zusätzliche Informationen
- ✅ Datenschutz-Checkbox (Pflicht)
- ✅ Spam-Schutz (Honeypot)
- ✅ AJAX-Formular (ohne Seiten-Reload)
- ✅ Automatische Bestätigungs-E-Mail an den Absender
- ✅ Professionelle E-Mail-Vorlage mit HTML
- ✅ Responsive Design (Mobile-friendly)

---

## 🚀 Installation (Schritt für Schritt)

### Schritt 1: PHP-Datei hochladen

1. **Öffne die Datei:** `angebot-verarbeiten.php`

2. **WICHTIG - Zeile 18 anpassen:**
   ```php
   $empfaenger_email = "info@bionic-world.net"; // ← DEINE E-MAIL HIER!
   ```
   Ändere zu deiner E-Mail-Adresse!

3. **Optional - Zeile 19 anpassen:**
   ```php
   $cc_email = ""; // Optional: CC-Empfänger
   ```
   Falls du eine Kopie an eine zweite Adresse senden willst.

4. **Datei hochladen** per FTP/Dateimanager nach:
   ```
   /bionic_world_net/angebot-verarbeiten.php
   ```

5. **Dateiberechtigung setzen:** 644
   ```bash
   chmod 644 angebot-verarbeiten.php
   ```

### Schritt 2: Custom HTML Modul erstellen

**VARIANTE A: Als Modul (empfohlen für flexible Positionierung)**

1. **Backend** → **Inhalt** → **Seitenmodule**
2. Klicke **"Neu"**
3. Wähle **"Custom HTML"**

**Ausfüllen:**
- 📝 **Titel:** "Angebotsanfrage Formular"
- 🔧 **Editor vorbereiten:** NEIN (WICHTIG!)
- 📋 **Custom Output:** 
  - Öffne die Datei `angebotsanfrage-formular.html`
  - Kopiere den KOMPLETTEN Inhalt
  - Füge ihn in das Feld ein
- 📍 **Position:** "main-bottom" (oder wo du willst)
- ✅ **Status:** Veröffentlicht
- 🎯 **Menüzuweisung:** 
  - "Nur auf den gewählten Seiten"
  - Wähle die Angebotsanfrage-Seite

4. **Speichern & Schließen**

**VARIANTE B: Als Beitrag (empfohlen für volle Seite)**

1. **Backend** → **Inhalt** → **Beiträge**
2. Klicke **"Neu"**
3. **Titel:** "Angebotsanfrage"
4. **Editor wechseln:** 
   - Klicke auf "Code" Button (wenn TinyMCE)
   - Oder verwende "Toggle Editor" Button
5. **Inhalt einfügen:**
   - Kopiere KOMPLETTEN Inhalt aus `angebotsanfrage-formular.html`
   - Füge ein
6. **Kategorie:** Wähle eine passende
7. **Status:** Veröffentlicht
8. **Speichern**

### Schritt 3: Menüpunkt erstellen

1. **Menüs** → **Hauptmenü** (oder dein Menü)
2. Klicke **"Neu"**

**Ausfüllen:**
- 📝 **Menütitel:** "Angebot anfragen" oder "Angebotsanfrage"
- 🔗 **Menütyp:** 
  - Klicke "Auswählen"
  - **Beiträge** → **Einzelner Beitrag**
  - Wähle den gerade erstellten Beitrag
- ✅ **Status:** Veröffentlicht
- 📊 **Übergeordneter Eintrag:** Top (oder wo du willst)

3. **Speichern & Schließen**

### Schritt 4: Datenschutz-Link anpassen

Im HTML (Zeile ~415) steht:
```html
<a href="/datenschutz" target="_blank">Datenschutzerklärung</a>
```

**Falls deine Datenschutzseite anders heißt, ändere den Link:**
```html
<a href="/deine-datenschutzseite" target="_blank">Datenschutzerklärung</a>
```

### Schritt 5: Testen

1. **Öffne die Angebotsanfrage-Seite**
2. **Fülle das Formular aus:**
   - Alle Pflichtfelder
   - Mindestens ein Angebot anklicken
   - Datenschutz akzeptieren
3. **Absenden**
4. **Prüfe:**
   - ✅ Erfolgs-Nachricht erscheint?
   - ✅ E-Mail kommt an?
   - ✅ Bestätigungs-E-Mail beim Absender?

---

## 🎨 Anpassungen

### Angebots-Namen und Icons ändern

Im HTML finde (ca. Zeile 250-380) die Angebote und ändere:

**Beispiel - Angebot 1 ändern:**
```html
<div class="angebot-icon">🔧</div>  <!-- ← Icon ändern -->
<div class="angebot-name">KI in Prozesssteuerungen</div>  <!-- ← Name ändern -->
<div class="angebot-desc">Intelligente Steuerungssysteme</div>  <!-- ← Beschreibung ändern -->
```

**Verfügbare Icons (Emojis):**
- 🔧 🏭 📊 ⚙️ 🎓 🛡️ 💡 🔐 📚
- 🚀 💻 📱 🌐 🔬 📈 💰 🏢 👥
- ⚡ 🎯 🔍 📝 📞 ✉️ 🎨 🔔

### Farben anpassen

Im CSS (Zeile 6-200) kannst du ändern:

**Primärfarbe ändern:**
```css
/* Statt var(--primary-color) verwendest du: */
background: #FF6B6B;  /* Deine Farbe */
```

**Gradient ändern:**
```css
background: linear-gradient(135deg, #FF6B6B, #4ECDC4);
```

### Pflichtfelder ändern

**Ein Feld optional machen:**

Suche das Feld und:
1. Entferne `required` aus dem `<input>`
2. Entferne die Klasse `required` vom `<label>`

**Beispiel:**
```html
<!-- Vorher (Pflichtfeld) -->
<label class="form-label required" for="telefon">Telefon</label>
<input type="tel" id="telefon" name="telefon" class="form-input" required>

<!-- Nachher (Optional) -->
<label class="form-label" for="telefon">Telefon</label>
<input type="tel" id="telefon" name="telefon" class="form-input">
```

### Zusätzliche Felder hinzufügen

**Beispiel: Firmen-Website hinzufügen:**

```html
<div class="form-group">
    <label class="form-label" for="website">Website</label>
    <input type="url" id="website" name="website_firma" class="form-input" 
           placeholder="https://www.ihre-firma.de">
</div>
```

**WICHTIG:** 
- Im PHP (angebot-verarbeiten.php) muss das Feld auch verarbeitet werden
- Name darf NICHT "website" sein (Honeypot!)

### Text in Bestätigungs-E-Mail ändern

In `angebot-verarbeiten.php` (Zeile 275-300):

```php
<p>Sehr geehrte/r ' . $vorname . ' ' . $nachname . ',</p>
<p>vielen Dank für Ihre Angebotsanfrage...</p>
```

Ändere den Text nach deinen Wünschen.

---

## 📧 E-Mail-Konfiguration

### SMTP einrichten (empfohlen)

Damit E-Mails sicher ankommen:

1. **Backend** → **System** → **Konfiguration**
2. **Tab "Server"**
3. **Mail senden:** SMTP
4. **Konfiguriere:**

**Für Gmail:**
```
SMTP Host: smtp.gmail.com
SMTP Port: 587
SMTP Sicherheit: TLS
SMTP Authentifizierung: Ja
SMTP Benutzername: deine@gmail.com
SMTP Passwort: [App-Passwort erstellen!]
```

**Für andere Provider:**
- **1&1/IONOS:** smtp.ionos.de (Port 587)
- **Strato:** smtp.strato.de (Port 465, SSL)
- **GMX:** mail.gmx.net (Port 587)
- **Web.de:** smtp.web.de (Port 587)

5. **Test-E-Mail senden:**
   - Klicke "Test-E-Mail senden" Button
   - Prüfe ob sie ankommt

### E-Mail-Template anpassen

In `angebot-verarbeiten.php` (Zeile 150-250):

**Farben ändern:**
```php
.header {
    background: linear-gradient(135deg, #FF6B6B, #4ECDC4); /* Deine Farben */
}
```

**Logo einfügen:**
```php
<div class="header">
    <img src="https://www.bionic-world.net/images/logo.png" alt="Logo" style="max-width: 200px;">
    <h1>🎯 Neue Angebotsanfrage</h1>
</div>
```

---

## 🔒 Sicherheit & Spam-Schutz

### Integrierte Schutzmaßnahmen

1. **Honeypot-Feld** (unsichtbar für Menschen)
   - Bots füllen es aus → werden blockiert
   
2. **Input-Bereinigung**
   - Alle Eingaben werden gefiltert
   - XSS-Schutz aktiv
   
3. **E-Mail-Validierung**
   - Nur gültige E-Mail-Adressen

4. **Pflichtfeld-Prüfung**
   - Client-seitig (JavaScript)
   - Server-seitig (PHP)

### Zusätzlicher Schutz (optional)

**Google reCAPTCHA hinzufügen:**

1. **Registriere auf:** https://www.google.com/recaptcha/admin
2. **Kopiere Keys**
3. **Im HTML vor dem Submit-Button einfügen:**

```html
<div class="g-recaptcha" data-sitekey="DEIN_SITE_KEY"></div>
```

4. **Script im Head einfügen:**
```html
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
```

5. **PHP anpassen** (Zeile 100):
```php
// reCAPTCHA Validierung
$recaptcha_secret = 'DEIN_SECRET_KEY';
$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

$verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
$captcha_success = json_decode($verify);

if (!$captcha_success->success) {
    sendErrorResponse('Captcha-Validierung fehlgeschlagen.');
}
```

---

## 📱 Responsive Design testen

**Teste auf verschiedenen Geräten:**

- ✅ **Desktop** (1920px, 1366px, 1024px)
- ✅ **Tablet** (768px, 1024px)
- ✅ **Smartphone** (375px, 414px, 360px)

**Browser-Testen:**
```
Chrome DevTools: F12 → Toggle Device Toolbar
Firefox: F12 → Responsive Design Mode
Safari: Entwickler → Responsive Design Mode
```

---

## 🆘 Fehlersuche

### Problem: E-Mails kommen nicht an

**Lösung 1: SMTP konfigurieren**
- Siehe Abschnitt "E-Mail-Konfiguration"

**Lösung 2: Spam-Ordner prüfen**
- Erste E-Mails landen oft im Spam
- Als "kein Spam" markieren

**Lösung 3: PHP mail() testen**
```php
mail('test@domain.de', 'Test', 'Test-Nachricht');
```

**Lösung 4: Server-Logs prüfen**
```bash
tail -f /var/log/mail.log
```

### Problem: Formular wird nicht angezeigt

**Lösung:**
- Cache leeren (System → Cache)
- Browser-Cache mit Strg+F5
- Editor-Modus prüfen (NEIN bei "Editor vorbereiten")
- HTML komplett kopiert?

### Problem: JavaScript-Fehler

**Lösung:**
- F12 → Console öffnen
- Fehler lesen
- Meist: Script nicht vollständig kopiert

### Problem: Checkboxen funktionieren nicht

**Lösung:**
- Stelle sicher, dass CSS vollständig kopiert wurde
- Prüfe mit F12 ob Styles geladen werden

### Problem: Datenschutz-Link geht nicht

**Lösung:**
- Link im HTML anpassen (siehe Schritt 4)
- Prüfe ob Datenschutzseite existiert

---

## ✅ Pre-Launch Checkliste

Vor dem Go-Live alles prüfen:

- [ ] PHP-Datei hochgeladen und E-Mail korrekt
- [ ] Formular wird angezeigt
- [ ] Alle Felder funktionieren
- [ ] Mindestens ein Angebot wählbar
- [ ] Datenschutz-Checkbox funktioniert
- [ ] E-Mail kommt beim Empfänger an
- [ ] Bestätigungs-E-Mail beim Absender
- [ ] Responsive Design getestet
- [ ] SMTP konfiguriert
- [ ] Spam-Schutz aktiv
- [ ] SSL/HTTPS aktiv
- [ ] Datenschutz-Link funktioniert
- [ ] Mobile-Ansicht getestet
- [ ] Verschiedene Browser getestet

---

## 🎯 Best Practices

### E-Mail-Eingang optimieren

1. **SPF-Record setzen** (DNS)
   ```
   v=spf1 mx ~all
   ```

2. **DKIM aktivieren** (bei deinem Provider)

3. **SMTP statt mail()** verwenden

4. **Von-Adresse** = Domain der Website

### Conversion-Rate verbessern

1. **Kurze Formulare** = mehr Anfragen
2. **Wenige Pflichtfelder** = weniger Abbrüche
3. **Klare Call-to-Actions**
4. **Vertrauenssiegel** anzeigen
5. **Schnelle Ladezeiten**

### DSGVO-Konform

1. **Datenschutz-Checkbox** (vorhanden ✅)
2. **Datenschutzerklärung** verlinkt (vorhanden ✅)
3. **Daten nur für Angebot verwenden**
4. **Nach Bearbeitung löschen** (falls nicht Kunde)
5. **SSL-Verschlüsselung** aktiv

---

## 📞 Support & Hilfe

**Joomla-spezifische Probleme:**
- Joomla Dokumentation: https://docs.joomla.org
- Joomla Forum: https://forum.joomla.org

**PHP/E-Mail Probleme:**
- PHP Error Logs prüfen
- Provider-Support kontaktieren

**Template-Probleme:**
- CSS im Browser-Inspector prüfen
- Template-CSS kann überschreiben

---

## 🎁 Bonus-Features

### Analytics-Tracking hinzufügen

Im HTML vor `</form>`:
```html
<script>
document.getElementById('angebotsForm').addEventListener('submit', function() {
    // Google Analytics Event
    gtag('event', 'form_submit', {
        'event_category': 'Angebot',
        'event_label': 'Angebotsanfrage'
    });
    
    // Facebook Pixel
    fbq('track', 'Lead');
});
</script>
```

### Automatische Weiterleitung nach Erfolg

Im JavaScript (Zeile 445):
```javascript
if (data.success) {
    // Nach 3 Sekunden zur Danke-Seite
    setTimeout(function() {
        window.location.href = '/danke';
    }, 3000);
}
```

### Datei-Upload hinzufügen

```html
<div class="form-group">
    <label class="form-label" for="anhang">Dokument anhängen (optional)</label>
    <input type="file" id="anhang" name="anhang" class="form-input" 
           accept=".pdf,.doc,.docx" multiple>
</div>
```

**PHP anpassen für Datei-Upload:**
```php
// Dateien verarbeiten
if (!empty($_FILES['anhang']['name'][0])) {
    // Datei-Upload-Logik hier
}
```

---

**Copyright © 2024 Bionic World**
**Version 1.0 - Angebotsanfrage Setup Guide**
