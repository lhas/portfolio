<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'portfolio');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'G.lktKGkf0iFPT+%D%4ehuyJ++)V~`VU:#C-07V2qt<LB8j|(3i6B7238u-^m.^I');
define('SECURE_AUTH_KEY',  'UBwe MX=*0V?`A5OpqDs%PpTrf4_[$j!lfwgpIx*;]!wjNGJQ7F;Iu`,ggj8tH|>');
define('LOGGED_IN_KEY',    'Y<q8Hc=2/jwI.]95S55>7Kvk{ZAbiyzE5VtdudZ#HCYUI1d~NA[bCc1pMb6V|5Ff');
define('NONCE_KEY',        'JW}SMmgQ.YY;x|id#=RqF,CY;(BdWKA@{z1y=57-!3]d0/[H{oW`zO&Mb-WlyTsu');
define('AUTH_SALT',        '9[Gw)c9x2{HS{sTy;U1JYZXHq&MdBL*UJ]+a^*Qsi65YmXqyU98YwQiA=<>rp%y5');
define('SECURE_AUTH_SALT', '<(GrKrT4^mpp<@ t:IwHgSFz-QbJ3 `ot<g|F~s8PQp+O,-gW8dG?n0qj^W[UhG/');
define('LOGGED_IN_SALT',   'XH@%J-{;c|r{w(`<r&IJOTBb4^}*IO|/[6*ig11)ei[OaJ]v) L|UJR+QTd+`Hq^');
define('NONCE_SALT',       '}W7hO0:E:JR(O|X&YuZ>ABgEo(|OM7vlR*<Pv?F85m%I-{!D<gZ`>Fak%,Z{Eq,7');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
