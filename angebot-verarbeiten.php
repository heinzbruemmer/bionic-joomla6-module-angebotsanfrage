<?php
/**
 * Angebotsanfrage Verarbeitung - Bionic World
 * Version: 1.0
 * 
 * WICHTIG: Diese Datei muss im Joomla-Hauptverzeichnis liegen
 * z.B. /bionic_world_net/angebot-verarbeiten.php
 */

// Joomla Framework laden (optional, für zusätzliche Sicherheit)
// define('_JEXEC', 1);
// define('JPATH_BASE', __DIR__);

// Session starten für Spam-Schutz
session_start();

// JSON-Response Header
header('Content-Type: application/json; charset=utf-8');

// ============================================================================
// KONFIGURATION - BITTE ANPASSEN!
// ============================================================================

$empfaenger_email = "info@bionic-world.net"; // Ihre E-Mail-Adresse
$cc_email = ""; // Optional: CC-Empfänger
$betreff_prefix = "Neue Angebotsanfrage";

// ============================================================================
// FUNKTIONEN
// ============================================================================

function sendErrorResponse($message) {
    echo json_encode([
        'success' => false,
        'message' => $message
    ]);
    exit;
}

function sendSuccessResponse($message = 'Ihre Anfrage wurde erfolgreich versendet.') {
    echo json_encode([
        'success' => true,
        'message' => $message
    ]);
    exit;
}

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// ============================================================================
// HAUPTLOGIK
// ============================================================================

// Prüfe ob POST-Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendErrorResponse('Ungültige Anfrage-Methode.');
}

// Honeypot Spam-Schutz
if (!empty($_POST['website'])) {
    // Bot erkannt - Erfolg vortäuschen
    sendSuccessResponse();
}

// ============================================================================
// DATEN VALIDIEREN UND BEREINIGEN
// ============================================================================

$errors = [];

// Persönliche Daten
$vorname = cleanInput($_POST['vorname'] ?? '');
$nachname = cleanInput($_POST['nachname'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$telefon = cleanInput($_POST['telefon'] ?? '');
$firma = cleanInput($_POST['firma'] ?? '');
$position = cleanInput($_POST['position'] ?? '');

// Angebote (Array)
$angebote = $_POST['angebote'] ?? [];
if (!is_array($angebote)) {
    $angebote = [];
}
$angebote = array_map('cleanInput', $angebote);

// Nachricht
$nachricht = cleanInput($_POST['nachricht'] ?? '');

// Datenschutz
$datenschutz = isset($_POST['datenschutz']) ? true : false;

// Validierung
if (empty($vorname) || strlen($vorname) < 2) {
    $errors[] = 'Bitte geben Sie einen gültigen Vornamen ein.';
}

if (empty($nachname) || strlen($nachname) < 2) {
    $errors[] = 'Bitte geben Sie einen gültigen Nachnamen ein.';
}

if (!$email) {
    $errors[] = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
}

if (empty($firma) || strlen($firma) < 2) {
    $errors[] = 'Bitte geben Sie eine gültige Firma/Organisation ein.';
}

if (empty($angebote)) {
    $errors[] = 'Bitte wählen Sie mindestens ein Angebot aus.';
}

if (!$datenschutz) {
    $errors[] = 'Bitte akzeptieren Sie die Datenschutzerklärung.';
}

// Bei Fehlern: Abbruch
if (!empty($errors)) {
    sendErrorResponse(implode(' ', $errors));
}

// ============================================================================
// E-MAIL VORBEREITEN
// ============================================================================

// Vollständiger Name
$vollstaendigerName = $vorname . ' ' . $nachname;

// Angebote als HTML-Liste
$angeboteListe = '';
foreach ($angebote as $angebot) {
    $angeboteListe .= '<li style="margin-bottom: 8px;">' . $angebot . '</li>';
}

// E-Mail Betreff
$email_betreff = $betreff_prefix . ' von ' . $vollstaendigerName . ' (' . $firma . ')';

// E-Mail HTML
$email_body = '
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 20px;
            color: #0099cc;
            border-bottom: 2px solid #00d4ff;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #0099cc;
            display: inline-block;
            min-width: 150px;
        }
        .value {
            color: #333;
        }
        .angebote-list {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #00d4ff;
        }
        .angebote-list ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .angebote-list li {
            color: #333;
            padding: 5px 0;
        }
        .nachricht-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #0099cc;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            border-top: 1px solid #e0e0e0;
            font-size: 13px;
            color: #666;
        }
        .footer-info {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎯 Neue Angebotsanfrage</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            
            <!-- Persönliche Daten -->
            <div class="section">
                <h2 class="section-title">👤 Kontaktdaten</h2>
                <div class="field">
                    <span class="label">Name:</span>
                    <span class="value">' . $vollstaendigerName . '</span>
                </div>
                <div class="field">
                    <span class="label">E-Mail:</span>
                    <span class="value"><a href="mailto:' . $email . '">' . $email . '</a></span>
                </div>
                ' . (!empty($telefon) ? '
                <div class="field">
                    <span class="label">Telefon:</span>
                    <span class="value"><a href="tel:' . $telefon . '">' . $telefon . '</a></span>
                </div>
                ' : '') . '
                <div class="field">
                    <span class="label">Firma:</span>
                    <span class="value">' . $firma . '</span>
                </div>
                ' . (!empty($position) ? '
                <div class="field">
                    <span class="label">Position:</span>
                    <span class="value">' . $position . '</span>
                </div>
                ' : '') . '
            </div>
            
            <!-- Gewählte Angebote -->
            <div class="section">
                <h2 class="section-title">✅ Gewählte Leistungen (' . count($angebote) . ')</h2>
                <div class="angebote-list">
                    <ul>
                        ' . $angeboteListe . '
                    </ul>
                </div>
            </div>
            
            <!-- Nachricht -->
            ' . (!empty($nachricht) ? '
            <div class="section">
                <h2 class="section-title">💬 Nachricht</h2>
                <div class="nachricht-box">' . nl2br($nachricht) . '</div>
            </div>
            ' : '') . '
            
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-info">
                <strong>Eingegangen am:</strong> ' . date('d.m.Y') . ' um ' . date('H:i') . ' Uhr
            </div>
            <div class="footer-info">
                <strong>IP-Adresse:</strong> ' . $_SERVER['REMOTE_ADDR'] . '
            </div>
            <div class="footer-info">
                <strong>User Agent:</strong> ' . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . '
            </div>
        </div>
    </div>
</body>
</html>
';

// E-Mail Headers
$headers = [];
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-Type: text/html; charset=UTF-8";
$headers[] = "From: " . $vollstaendigerName . " <" . $email . ">";
$headers[] = "Reply-To: " . $email;
$headers[] = "X-Mailer: PHP/" . phpversion();

// Optional: CC
if (!empty($cc_email)) {
    $headers[] = "Cc: " . $cc_email;
}

// ============================================================================
// E-MAIL SENDEN
// ============================================================================

$versendet = mail($empfaenger_email, $email_betreff, $email_body, implode("\r\n", $headers));

if ($versendet) {
    // Optional: Bestätigungs-E-Mail an den Absender senden
    $bestaetigung_betreff = "Ihre Angebotsanfrage bei Bionic World";
    $bestaetigung_body = '
    <!DOCTYPE html>
    <html>
    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background: linear-gradient(135deg, #00d4ff, #0099cc); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
                <h1 style="margin: 0;">Vielen Dank für Ihre Anfrage!</h1>
            </div>
            <div style="padding: 30px; background: #f8f9fa; border-radius: 0 0 10px 10px;">
                <p>Sehr geehrte/r ' . $vorname . ' ' . $nachname . ',</p>
                <p>vielen Dank für Ihre Angebotsanfrage. Wir haben Ihre Anfrage erhalten und werden uns schnellstmöglich bei Ihnen melden.</p>
                <p><strong>Ihre gewählten Leistungen:</strong></p>
                <ul>' . $angeboteListe . '</ul>
                <p>Bei Rückfragen erreichen Sie uns unter:<br>
                E-Mail: ' . $empfaenger_email . '<br>
                Telefon: +49 (0) 123 456789</p>
                <p>Mit freundlichen Grüßen,<br>
                Ihr <strong>Bionic World</strong> Team</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    $bestaetigung_headers = [];
    $bestaetigung_headers[] = "MIME-Version: 1.0";
    $bestaetigung_headers[] = "Content-Type: text/html; charset=UTF-8";
    $bestaetigung_headers[] = "From: Bionic World <" . $empfaenger_email . ">";
    
    mail($email, $bestaetigung_betreff, $bestaetigung_body, implode("\r\n", $bestaetigung_headers));
    
    // Erfolg zurückmelden
    sendSuccessResponse('Vielen Dank! Ihre Angebotsanfrage wurde erfolgreich versendet. Sie erhalten in Kürze eine Bestätigung per E-Mail.');
    
} else {
    // Fehler beim Versenden
    sendErrorResponse('Es ist ein Fehler beim Versenden aufgetreten. Bitte versuchen Sie es später erneut oder kontaktieren Sie uns direkt per E-Mail.');
}
?>
