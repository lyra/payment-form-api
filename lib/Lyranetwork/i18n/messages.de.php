<?php
/**
 * This file is part of Lyra payment form API.
 * Copyright (C) Lyra Network.
 * See COPYING.txt for license details.
 */

/**
 * Associative array containing human-readable translations of response codes.
 *
 * @var array
 */
global $i18n;

$i18n = array();

$i18n['unknown'] = 'Unbekannt';

$i18n['result'] = array(
    'empty' => '',
    '00' => 'Zahlung mit Erfolg durchgeführt',
    '02' => 'Der Händler muss die Bank des Karteninhabers kontaktieren',
    '05' => 'Zahlung zurückgewiesen',
    '17' => 'Stornierung',
    '30' => 'Fehler im Format der Anfrage',
    '96' => 'Technischer Fehler bei der Zahlung'
);

$i18n['auth_result'] = array(
    'empty' => '',
    '00' => 'Zahlung durchgeführt oder mit Erfolg bearbeitet',
    '02' => 'Kartenausgebende Bank kontaktieren',
    '03' => 'Ungültiger Annehmer',
    '04' => 'Karte aufbewahren',
    '05' => 'Nicht einlösen',
    '07' => 'Karte aufbewahren, Sonderbedingungen',
    '08' => 'Nach Identifizierung genehmigen',
    '12' => 'Ungültige Transaktion',
    '13' => 'Ungültiger Betrag',
    '14' => 'Ungültige Nummer des Karteninhabers',
    '30' => 'Formatfehler',
    '31' => 'ID des Annehmers unbekannt',
    '33' => 'Gültigkeitsdatum der Karte überschritten',
    '34' => 'Verdacht auf Betrug',
    '41' => 'Verlorene Karte',
    '43' => 'Gestohlene Karte',
    '51' => 'Deckung unzureichend oder Kredit überschritten',
    '54' => 'Gültigkeitsdatum der Karte überschritten',
    '56' => 'Karte nicht in der Datei enthalten',
    '57' => 'Transaktion diesem Karteninhaber nicht erlaubt',
    '58' => 'Transaktion diesem Terminal nicht erlaubt',
    '59' => 'Verdacht auf Betrug',
    '60' => 'Der Kartenannehmer muss den Acquirer kontaktieren',
    '61' => 'Betrag der Abhebung überschreitet das Limit',
    '63' => 'Sicherheitsregelen nicht respektiert',
    '68' => 'Antwort nicht oder zu spät erhalten',
    '90' => 'Momentane Systemunterbrechung',
    '91' => 'Kartenausgeber nicht erreichbar',
    '96' => 'Fehlverhalten des Systems',
    '94' => 'Kopierte Transaktion',
    '97' => 'Fälligkeit der Verzögerung der globalen Überwachung',
    '98' => 'Server nicht erreichbar, Routen des Netzwerkes erneut angefragt',
    '99' => 'Vorfall der urhebenden Domain'
);

$i18n['warranty_result'] = array(
    'empty' => 'Zahlungsgarantie nicht anwendbar',
    'YES' => 'Die Zahlung ist garantiert',
    'NO' => 'Die Zahlung ist nicht garantiert',
    'UNKNOWN' => 'Die Zahlung kann aufgrund eines technischen Fehlers nicht gewährleistet werden'
);

$i18n['risk_control'] = array(
    'CARD_FRAUD' => 'Kontrolle der Kartennummer',
    'SUSPECT_COUNTRY' => 'Kontrolle des Landes, welches das Zahlungsmittel zur Verfügung stellt',
    'IP_FRAUD' => 'Kontrolle der IP Adresse',
    'CREDIT_LIMIT' => 'Kontrolle der ausstehenden Beträge',
    'BIN_FRAUD' => 'Blacklist der BIN-Codes',
    'ECB' => 'Kontrolle der E-CB-Karte',
    'COMMERCIAL_CARD' => 'Kontrolle der Firmenkarte',
    'SYSTEMATIC_AUTO' => 'Kontrolle der Karten mit systematischer Autorisierung',
    'INCONSISTENT_COUNTRIES' => 'Kontrolle des Zusammenhangs Land des Käufers, IP-Adresse, Karte',
    'NON_WARRANTY_PAYMENT' => 'Kontrolle des Haftungsübergangs der entstandenen Zahlungen',
    'SUSPECT_IP_COUNTRY' => 'Kontrolle des Landes der IP Adresse'
);

$i18n['risk_assessment'] = array(
    'ENABLE_3DS' => '3-D Secure enabled',
    'DISABLE_3DS' => '3-D Secure disabled',
    'MANUAL_VALIDATION' => 'The transaction has been created via manual validation',
    'REFUSE' => 'The transaction is refused',
    'RUN_RISK_ANALYSIS' => 'Call for an external risk analyser',
    'INFORM' => 'A warning message appears'
);

$i18n['ipn_response'] = array(
    'payment_ok' => 'Gültige Zahlung bearbeitet',
    'payment_ko' => 'Ungültige Zahlung bearbeitet',
    'payment_ok_already_done' => 'Gültige Zahlung bearbeitet, schon registriert',
    'payment_ko_already_done' => 'Ungültige Zahlung bearbeitet, schon registriert',
    'ok' => '',
    'order_not_found' => 'Bestellung nicht auffindbar',
    'payment_ko_on_order_ok' => 'Ungültiger Zahlungscode für eine bereits bestätigte Bestellung erhalten',
    'auth_fail' => 'Authentifizierungsfehler',
    'empty_cart' => 'Der Warenkorb wurde vor Weiterleitung geleert',
    'unknown_status' => 'Unbekannt Bestellungstatus',
    'amount_error' => 'Gezahlten Betrag unterscheidet sich vom Anfangsbetrag',
    'ko' => ''
);
