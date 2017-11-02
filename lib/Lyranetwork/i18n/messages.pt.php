<?php
/**
 * Copyright (C) 2017 Lyra Network.
 * This file is part of Lyra payment form API.
 * See COPYING.txt for license details.
 *
 * @author Lyra Network <contact@lyra-network.com>
 * @copyright 2017 Lyra Network
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

/**
 * Associative array containing human-readable translations of response codes.
 *
 * @var array
 */
global $i18n;

$i18n = array();

$i18n['unknown'] = 'Desconhecido';

$i18n['result'] = array(
    'empty' => '',
    '00' => 'Pagamento realizado com sucesso',
    '02' => 'O comerciante deve contactar o banco do portador',
    '05' => 'Pagamento recusado',
    '17' => 'Cancelamento',
    '30' => 'Erro no formato dos dados',
    '96' => 'Erro técnico durante o pagamento'
);

$i18n['auth_result'] = array(
    'empty' => '',
    '00' => 'Transação aprovada ou tratada com sucesso',
    '02' => 'Contactar o emissor do cartão',
    '03' => 'Recebedor inválido',
    '04' => 'Conservar o cartão',
    '05' => 'Não honrar',
    '07' => 'Conservar o cartão, condições especiais',
    '08' => 'Aprovar após identificação',
    '12' => 'Transação inválida',
    '13' => 'Valor inválido',
    '14' => 'Número do portador inválido',
    '30' => 'Erro no formato',
    '31' => 'Identificação do adquirente desconhecido',
    '33' => 'Data de validade do cartão ultrapassada',
    '34' => 'Suspeita de fraude',
    '41' => 'Cartão perdido',
    '43' => 'Cartão roubado',
    '51' => 'Saldo insuficiente ou limite excedido',
    '54' => 'Data de validade do cartão ultrapassada',
    '56' => 'Cartão ausente do arquivo',
    '57' => 'Transação não permitida para este portador',
    '58' => 'Transação proibida no terminal',
    '59' => 'Suspeita de fraude',
    '60' => 'O recebedor do cartão deve contactar o adquirente',
    '61' => 'Valor de saque fora do limite',
    '63' => 'Regras de segurança não respeitadas',
    '68' => 'Nenhuma resposta recebida ou recebida tarde demais',
    '90' => 'Parada momentânea do sistema',
    '91' => 'Emissor do cartão inacessível',
    '96' => 'Mau funcionamento do sistema',
    '94' => 'Transação duplicada',
    '97' => 'Limite do tempo de monitoramento global',
    '98' => 'Servidor indisponível nova solicitação de roteamento',
    '99' => 'Incidente no domínio iniciador'
);

$i18n['warranty_result'] = array(
    'empty' => 'Garantia de pagamento não aplicável',
    'YES' => 'O pagamento foi garantido',
    'NO' => 'O pagamento não foi garantido',
    'UNKNOWN' => 'Devido à un erro técnico, o pagamento não pôde ser garantido'
);

$i18n['risk_control'] = array(
    'CARD_FRAUD' => 'Controle número de cartão',
    'SUSPECT_COUNTRY' => 'Ctrl. país meio de pagamento',
    'IP_FRAUD' => 'Controle de endereços IP',
    'CREDIT_LIMIT' => 'Controle do acumulado financeiro',
    'BIN_FRAUD' => 'Controle do código BIN',
    'ECB' => 'Controle e-Carte Bleue',
    'COMMERCIAL_CARD' => 'Controle cartão comercial',
    'SYSTEMATIC_AUTO' => 'Controle de cartão com autorização sistemática',
    'INCONSISTENT_COUNTRIES' => 'Controle de coerência dos países comprador, IP e cartão',
    'NON_WARRANTY_PAYMENT' => 'Controle de transferência de responsabilidade',
    'SUSPECT_IP_COUNTRY' => 'Controle país IP'
);

$i18n['risk_assessment'] = array(
    'ENABLE_3DS' => '3-D Secure ativado',
    'DISABLE_3DS' => '3-D Secure desativado',
    'MANUAL_VALIDATION' => 'A transação foi criada em validação manual',
    'REFUSE' => 'A transação foi recusada',
    'RUN_RISK_ANALYSIS' => 'Chamada para um analisador de riscos externos',
    'INFORM' => 'Uma alerta apareceu'
);

$i18n['ipn_response'] = array(
    'payment_ok' => 'Pagamento válido tratado',
    'payment_ko' => 'Pagamento inválido tratado',
    'payment_ok_already_done' => 'Pagamento válido tratado, já registrado',
    'payment_ko_already_done' => 'Pagamento inválido tratado, já registrado',
    'ok' => '',
    'order_not_found' => 'Impossível de encontrar o pedido',
    'payment_ko_on_order_ok' => 'Código de pagamento inválido recebido por um pedido já validado',
    'auth_fail' => 'Falha na autenticação',
    'empty_cart' => 'O carrinho foi esvaziado antes do redirecionamento',
    'unknown_status' => 'Status de pedido desconhecido',
    'amount_error' => 'O valor pago é diferente do valor inicial',
    'ko' => ''
);
