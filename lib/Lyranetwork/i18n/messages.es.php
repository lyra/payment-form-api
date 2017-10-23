<?php
/**
 * Copyright (C) 2017 Lyra Network.
 * This file is part of Lyra payment form API.
 *
 * See COPYING.txt for license details.
 *
 * @author    Lyra Network <contact@lyra-network.com>
 * @copyright 2017 Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

/**
 * Associative array containing human-readable translations of response codes.
 *
 * @var array
 */
global $i18n;

$i18n = array();

$i18n['unknown'] = 'Desconocido';

$i18n['result'] = array(
    'empty' => '',
    '00' => 'Accion procesada con exito',
    '02' => 'El mercante debe contactar el banco del portador',
    '05' => 'Accion rechazada',
    '17' => 'Accion cancelada',
    '30' => 'Error de formato de solicitutd',
    '96' => 'Problema technico'
);

$i18n['auth_result'] = array(
    'empty' => '',
    '00' => 'Transaccion aceptada o procesada con exito',
    '02' => 'Contact el emisor de la tarjeta',
    '03' => 'Adquirente invalido',
    '04' => 'Retener tarjeta',
    '05' => 'No honrar',
    '07' => 'Retener tarjeta, condiciones especiales',
    '08' => 'Confirmar despues identificacion',
    '12' => 'Transaccion invalida',
    '13' => 'Importe invalido',
    '14' => 'Numero de portador invalido',
    '30' => 'Error de formato',
    '31' => 'Identificador adquirente desconocido',
    '33' => 'Tarjeta caducada',
    '34' => 'Fraude sospechado',
    '41' => 'Tarjeta perdida',
    '43' => 'Tarjeta robada',
    '51' => 'Saldo insuficiente o limite de credito sobrepasado',
    '54' => 'Tarjeta caducada',
    '56' => 'Tarjeta ausente del archivo',
    '57' => 'Transaccion no permitida a este portador',
    '58' => 'Transaccion no permitida a este portador',
    '59' => 'Fraude sospechado',
    '60' => 'El aceptador de la tarjeta debe contactar el adquirente',
    '61' => 'Limite de retirada sobrepasada',
    '63' => 'Reglas de suguridad no cumplidas',
    '68' => 'Respuesta no recibiba o recibida demasiado tarde',
    '90' => 'Interrupcion temporera',
    '91' => 'No se puede contactar el emisor de tarjeta',
    '96' => 'Malfunction del sistema',
    '94' => 'Transaccion duplicada',
    '97' => 'Supervision timeout',
    '98' => 'Servidor no disonible, nueva ruta pedida',
    '99' => 'Incidente de dominio iniciador'
);

$i18n['warranty_result'] = array(
    'empty' => 'Garantia de pago no aplicable',
    'YES' => 'El pago es garantizado',
    'NO' => 'El pago no es garantizado',
    'UNKNOWN' => 'Debido a un problema tecnico, el pago no puede ser garantizado'
);

$i18n['risk_control'] = array(
    'CARD_FRAUD' => 'Control de numero de tarjeta',
    'SUSPECT_COUNTRY' => 'Control de pais de tarjeta',
    'IP_FRAUD' => 'Control de direccion IP',
    'CREDIT_LIMIT' => 'Control de saldo de vivo de tarjeta',
    'BIN_FRAUD' => 'Control de codigo BIN',
    'ECB' => 'Control de E-carte bleue',
    'COMMERCIAL_CARD' => 'Control de tarjeta comercial',
    'SYSTEMATIC_AUTO' => 'Control de tarjeta a autorizacion sistematica',
    'INCONSISTENT_COUNTRIES' => 'Control de coherencia de pais (IP, tarjeta, direccion de envio)',
    'NON_WARRANTY_PAYMENT' => 'Control de transferencia de responsabilidad',
    'SUSPECT_IP_COUNTRY' => 'Control del pais de la IP'
);

$i18n['risk_assessment'] = array(
    'ENABLE_3DS' => '3-D Secure activado',
    'DISABLE_3DS' => '3-D Secure desactivado',
    'MANUAL_VALIDATION' => 'La transaccion ha sido creada con validacion manual',
    'REFUSE' => 'La transaccion ha sido rechazada',
    'RUN_RISK_ANALYSIS' => 'Llamada a un analisador de riesgos exterior',
    'INFORM' => 'Un mensaje de advertencia aparece'
);

$i18n['ipn_response'] = array(
    'payment_ok' => 'Pago válido procesado',
    'payment_ko' => 'Pago no válido procesado',
    'payment_ok_already_done' => 'Pago válido procesado, ya guardado',
    'payment_ko_already_done' => 'Pago no válido procesado, ya guardado',
    'ok' => '',
    'order_not_found' => 'Pedido no encontrado',
    'payment_ko_on_order_ok' => 'Resultado de pago no válido recibido por pedido ya validado',
    'auth_fail' => 'Error de autenticación',
    'empty_cart' => 'El carrito se vació antes de la redirección',
    'unknown_status' => 'Estado de pedido desconocido',
    'amount_error' => 'El monto pagado es diferente del monto inicial',
    'ko' => ''
);
