<?php
/**
 * Copyright (C) 2017-2018 Lyra Network.
 * This file is part of Lyra payment form API.
 * See COPYING.md for license details.
 *
 * @author Lyra Network <contact@lyra-network.com>
 * @copyright 2017-2018 Lyra Network
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

/**
 * Associative array containing human-readable translations of response codes.
 *
 * @var array
 */
global $i18n;

$i18n = array();

$i18n['unknown'] = 'Inconnu';

$i18n['result'] = array(
    'empty' => '',
    '00' => 'Paiement réalisé avec succès',
    '02' => 'Le marchand doit contacter la banque du porteur',
    '05' => 'Action refusé',
    '17' => 'Annulation',
    '30' => 'Erreur de format de la requête',
    '96' => 'Erreur technique'
);

$i18n['auth_result'] = array(
    'empty' => '',
    '00' => 'Transaction approuvée ou traitée avec succès',
    '02' => 'Contacter l\'émetteur de carte',
    '03' => 'Accepteur invalide',
    '04' => 'Conserver la carte',
    '05' => 'Ne pas honorer',
    '07' => 'Conserver la carte, conditions spéciales',
    '08' => 'Approuver après identification',
    '12' => 'Transaction invalide',
    '13' => 'Montant invalide',
    '14' => 'Numéro de porteur invalide',
    '30' => 'Erreur de format',
    '31' => 'Identifiant de l\'organisme acquéreur inconnu',
    '33' => 'Date de validité de la carte dépassée',
    '34' => 'Suspicion de fraude',
    '41' => 'Carte perdue',
    '43' => 'Carte volée',
    '51' => 'Provision insuffisante ou crédit dépassé',
    '54' => 'Date de validité de la carte dépassée',
    '56' => 'Carte absente du fichier',
    '57' => 'Transaction non permise à ce porteur',
    '58' => 'Transaction interdite au terminal',
    '59' => 'Suspicion de fraude',
    '60' => 'L\'accepteur de carte doit contacter l\'acquéreur',
    '61' => 'Montant de retrait hors limite',
    '63' => 'Règles de sécurité non respectées',
    '68' => 'Réponse non parvenue ou reçue trop tard',
    '90' => 'Arrêt momentané du système',
    '91' => 'Emetteur de cartes inaccessible',
    '96' => 'Mauvais fonctionnement du système',
    '94' => 'Transaction dupliquée',
    '97' => 'Echéance de la temporisation de surveillance globale',
    '98' => 'Serveur indisponible routage réseau demandé à nouveau',
    '99' => 'Incident domaine initiateur'
);

$i18n['warranty_result'] = array(
    'empty' => 'Garantie de paiement non applicable',
    'YES' => 'Le paiement est garanti',
    'NO' => 'Le paiement n\'est pas garanti',
    'UNKNOWN' => 'Suite à une erreur technique, le paiment ne peut pas être garanti'
);

$i18n['risk_control'] = array(
    'CARD_FRAUD' => 'Contrôle du numéro de carte',
    'SUSPECT_COUNTRY' => 'Contrôle du pays émetteur du moyen de paiement',
    'IP_FRAUD' => 'Contrôle de l\'adresse IP',
    'CREDIT_LIMIT' => 'Contrôle de l\'encours financier',
    'BIN_FRAUD' => 'Contrôle du code BIN',
    'ECB' => 'Contrôle e-carte bleue',
    'COMMERCIAL_CARD' => 'Contrôle carte commerciale',
    'SYSTEMATIC_AUTO' => 'Contrôle carte à autorisation systématique',
    'INCONSISTENT_COUNTRIES' => 'Contrôle de cohérence des pays (IP, carte, adresse de facturation)',
    'NON_WARRANTY_PAYMENT' => 'Contrôle le transfert de responsabilité',
    'SUSPECT_IP_COUNTRY' => 'Contrôle Pays de l\'IP'
);

$i18n['risk_assessment'] = array(
    'ENABLE_3DS' => '3-D Secure activé',
    'DISABLE_3DS' => '3-D Secure désactivé',
    'MANUAL_VALIDATION' => 'La transaction est créée en validation manuelle',
    'REFUSE' => 'La transaction est refusée',
    'RUN_RISK_ANALYSIS' => 'Appel à un analyseur de risques externes',
    'INFORM' => 'Une alerte est remontée'
);

$i18n['ipn_response'] = array(
    'payment_ok' => 'Paiement valide traité',
    'payment_ko' => 'Paiement invalide traité',
    'payment_ok_already_done' => 'Paiement valide traité, déjà enregistré',
    'payment_ko_already_done' => 'Paiement invalide traité, déjà enregistré',
    'ok' => '',
    'order_not_found' => 'Impossible de retrouver la commande',
    'payment_ko_on_order_ok' => 'Code paiement invalide reçu pour une commande déjà validée',
    'auth_fail' => 'Echec d\'authentification',
    'empty_cart' => 'Le panier a été vidé avant la redirection',
    'unknown_status' => 'Statut de commande inconnu',
    'amount_error' => 'Le montant payé est différent du montant intial',
    'ko' => ''
);
