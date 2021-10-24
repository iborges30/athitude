<?php

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */

/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param string $password
 * @return bool
 */
function is_passwd(string $password): bool
{
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN)) {
        return true;
    }

    return false;
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * @param string $string
 * @return string
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(["-----", "----", "---", "--"], "-",
        str_replace(" ", "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
    return $slug;
}

/**
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    $studlyCase = str_replace(" ", "",
        mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE)
    );

    return $studlyCase;
}

/**
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * @param string $string
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
}

/**
 * @param string $text
 * @return string
 */
function str_textarea(string $text): string
{
    $text = filter_var($text, FILTER_SANITIZE_STRIPPED);
    $arrayReplace = ["&#10;", "&#10;&#10;", "&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;&#10;"];
    return "<p>" . str_replace($arrayReplace, "</p><p>", $text) . "</p>";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(" ", $string);
    $numWords = count($arrWords);

    if ($numWords < $limit) {
        return $string;
    }

    $words = implode(" ", array_slice($arrWords, 0, $limit));
    return "{$words}{$pointer}";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), " "));
    return "{$chars}{$pointer}";
}

/**
 * @param string $price
 * @return string
 */
function str_price(?string $price): string
{
    return number_format((!empty($price) ? $price : 0), 2, ",", ".");
}

/**
 * @param string|null $search
 * @return string
 */
function str_search(?string $search): string
{
    if (!$search) {
        return "all";
    }

    $search = preg_replace("/[^a-z0-9A-Z\@\ ]/", "", $search);
    return (!empty($search) ? $search : "all");
}

/**
 * ###############
 * ###   URL   ###
 * ###############
 */

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

/**
 * @return string
 */
function url_back(): string
{
    return ($_SERVER['HTTP_REFERER'] ?? url());
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */

/**
 * @return \Source\Models\User|null
 */
function user(): ?\Source\Models\User
{
    return \Source\Models\Auth::user();
}

/**
 * @return \Source\Core\Session
 */
function session(): \Source\Core\Session
{
    return new \Source\Core\Session();
}

/**
 * @param string|null $path
 * @param string $theme
 * @return string
 */
function theme(string $path = null, string $theme = CONF_VIEW_THEME): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * @param string $image
 * @param int $width
 * @param int|null $height
 * @return string
 */
function image(?string $image, int $width, int $height = null): ?string
{
    if ($image) {
        return url() . "/" . (new \Source\Support\Thumb())->make($image, $width, $height);
    }

    return null;
}

/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_fmt(?string $date, string $format = "d/m/Y H\hi"): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format($format);
}

/**
 * @param string $date
 * @return string
 * @throws Exception
 */
function date_fmt_br(?string $date): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format(CONF_DATE_BR);
}

/**
 * @param string $date
 * @return string
 * @throws Exception
 */
function date_fmt_app(?string $date): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format(CONF_DATE_APP);
}

/**
 * @param string|null $date
 * @return string|null
 */
function date_fmt_back(?string $date): ?string
{
    if (!$date) {
        return null;
    }

    if (strpos($date, " ")) {
        $date = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $date[0]))) . " " . $date[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
 * @param string $password
 * @return string
 */
function passwd(string $password): string
{
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }

    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * @param string $hash
 * @return bool
 */
function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */

/**
 * @return string
 */
function csrf_input(): string
{
    $session = new \Source\Core\Session();
    $session->csrf();
    return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
}

/**
 * @param $request
 * @return bool
 */
function csrf_verify($request): bool
{
    $session = new \Source\Core\Session();
    if (empty($session->csrf_token) || empty($request['csrf']) || $request['csrf'] != $session->csrf_token) {
        return false;
    }
    return true;
}

/**
 * @return null|string
 */
function flash(): ?string
{
    $session = new \Source\Core\Session();
    if ($flash = $session->flash()) {
        return $flash;
    }
    return null;
}

/**
 * @param string $key
 * @param int $limit
 * @param int $seconds
 * @return bool
 */
function request_limit(string $key, int $limit = 5, int $seconds = 60): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests < $limit) {
        $session->set($key, [
            "time" => time() + $seconds,
            "requests" => $session->$key->requests + 1
        ]);
        return false;
    }

    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests >= $limit) {
        return true;
    }

    $session->set($key, [
        "time" => time() + $seconds,
        "requests" => 1
    ]);

    return false;
}

/**
 * @param string $field
 * @param string $value
 * @return bool
 */
function request_repeat(string $field, string $value): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($field) && $session->$field == $value) {
        return true;
    }

    $session->set($field, $value);
    return false;
}

/**
 * @param string|null $image
 * @param string $alt
 * @param int $width
 * @param int|null $height
 * @param string|null $defaultImage
 * @param string|null $class
 * @param string|null $style
 * @return string
 */
function photo_img(
    ?string $image,
    string $alt,
    int $width,
    int $height = null,
    string $defaultImage = null,
    string $class = null,
    string $style = null
): string
{
    $defaultImage = (!empty($defaultImage) ? $defaultImage : CONF_IMAGE_NO_AVAILABLE_16BY9);
    $class = (!empty($class) ? ' class="' . $class . '"' : null);
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    $image = (!empty($image) ? image($image, $width, $height) : theme($defaultImage));

    return '<img src="' . $image . '" alt="' . $alt . '"' . $class . $style . '>';
}

/**
 * @param string|null $image
 * @param int $width
 * @param int|null $height
 * @param string|null $defaultImage
 * @return string
 */
function photo_scr(?string $image, int $width, int $height = null, string $defaultImage = null): string
{
    $defaultImage = (!empty($defaultImage) ? $defaultImage : CONF_IMAGE_NO_AVAILABLE_16BY9);
    $image = (!empty($image) ? image($image, $width, $height) : theme($defaultImage));
    return $image;
}

/**
 * #################
 * ###   ALERT   ###
 * #################
 */

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_success(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_SUCCESS["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_SUCCESS["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_danger(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_DANGER["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_DANGER["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_warning(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_WARNING["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_WARNING["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/**
 * @param string $message
 * @param string|null $class
 * @param string|null $style
 * @param string $htmlTag
 * @return string
 */
function alert_info(string $message, string $class = null, string $style = null, string $htmlTag = "div"): string
{
    $class = CONF_ALERT_MESSAGE . " " . CONF_ALERT_INFO["class"] . (!empty($class) ? " {$class}" : null);
    $icon = '<i class="' . CONF_ALERT_INFO["icon"] . '"></i>';
    $style = (!empty($style) ? ' style="' . $style . '"' : null);
    return '<' . $htmlTag . ' class="' . $class . '" role="alert"' . $style . '>' . $icon . $message . '</' . $htmlTag . '>';
}

/*
 * SALVA VALOR MOEDA
 */
function saveMoney($getValor)
{
    $source = array('.', ',');
    $replace = array('', '.');
    $valor = str_replace($source, $replace, $getValor); //remove os pontos e substitui a virgula pelo ponto
    return $valor; //retorna o valor formatado para gravar no banco
}

/**
 * ###################################
 * ###   RETORNA STATUS  ###
 * ###################################
 */
function status($data = null)
{
    $status = ["active" => "Ativo", "inactive" => "Inativo"];
    if (!empty($data)) {
        return $status[$data];
    } else {
        return $status;
    }
}


/**
 * ###################################
 * ###   RETORNA CATEGORY PAYMENT  ###
 * ###################################
 */
function bgStatusOptionsItems($data = null)
{
    $status = [
        "active" => "badge-pill badge-success",
        "inactive" => "badge-pill badge-warning"
    ];
    if (!empty($data)) {
        return $status[$data];
    } else {
        return $status;
    }
}

/**
 * <b>Checa CNPJ:</b> Informe um CNPJ para checar sua validade via algoritmo!
 * @param STRING $CNPJ = CNPJ com ou sem pontuação
 * @return BOLEAM = True se for um CNJP válido
 */
function validateCnpj($Cnpj)
{
    $Cnpj = (string)$Cnpj;
    $Cnpj = preg_replace('/[^0-9]/', '', $Cnpj);

    if (strlen($Cnpj) != 14):
        return false;
    endif;

    $A = 0;
    $B = 0;

    for ($i = 0, $c = 5; $i <= 11; $i++, $c--):
        $c = ($c == 1 ? 9 : $c);
        $A += $Cnpj[$i] * $c;
    endfor;

    for ($i = 0, $c = 6; $i <= 12; $i++, $c--):
        if (str_repeat($i, 14) == $Cnpj):
            return false;
        endif;
        $c = ($c == 1 ? 9 : $c);
        $B += $Cnpj[$i] * $c;
    endfor;

    $somaA = (($A % 11) < 2) ? 0 : 11 - ($A % 11);
    $somaB = (($B % 11) < 2) ? 0 : 11 - ($B % 11);

    if (strlen($Cnpj) != 14):
        return false;
    elseif ($somaA != $Cnpj[12] || $somaB != $Cnpj[13]):
        return false;
    else:
        return true;
    endif;
}

function calculeInstallment($installment, $price)
{
    $installment = (empty($installment) ? 1 : $installment);
    $calcule = $price / $installment;
    return str_price(round($calcule, 2));
}


/*
 * FORMAT CNPJ
 */
function formatDocument($cpf_cnpj)
{
    /*
        Pega qualquer CPF e CNPJ e formata

        CPF: 000.000.000-00
        CNPJ: 00.000.000/0000-00
    */

    ## Retirando tudo que não for número.
    $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
    $tipo_dado = NULL;
    if (strlen($cpf_cnpj) == 11) {
        $tipo_dado = "cpf";
    }
    if (strlen($cpf_cnpj) == 14) {
        $tipo_dado = "cnpj";
    }
    switch ($tipo_dado) {
        default:
            $cpf_cnpj_formatado = "Não foi possível definir tipo de dado";
            break;

        case "cpf":
            $bloco_1 = substr($cpf_cnpj, 0, 3);
            $bloco_2 = substr($cpf_cnpj, 3, 3);
            $bloco_3 = substr($cpf_cnpj, 6, 3);
            $dig_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;
            break;

        case "cnpj":
            $bloco_1 = substr($cpf_cnpj, 0, 2);
            $bloco_2 = substr($cpf_cnpj, 2, 3);
            $bloco_3 = substr($cpf_cnpj, 5, 3);
            $bloco_4 = substr($cpf_cnpj, 8, 4);
            $digito_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;
            break;
    }
    return $cpf_cnpj_formatado;
}

function validadeDocumentClient($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

/**
 * ###################################
 * ###   RETORNA A FORMA DE PAGAMENTO  ###
 * ###################################
 */
function paymentMethod($data = null)
{
    $status = [
        "money" => "Dinheiro",
        "credit" => "Cartão de Crédito",
        "pix" => "Pix",
        "debit" => "Cartão de débito"
    ];
    if (!empty($data)) {
        return $status[$data];
    } else {
        return $status;
    }
}
