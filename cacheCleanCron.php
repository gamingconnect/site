<?php

require __DIR__.'/../../config/config.inc.php';

\Db::getInstance()->execute('UPDATE '._DB_PREFIX_."configuration SET value = 1 WHERE name = 'PS_SMARTY_CACHE'");
\Db::getInstance()->execute(
    'UPDATE '._DB_PREFIX_."configuration SET value = 'never' WHERE name = 'PS_SMARTY_CLEAR_CACHE'"
);

//Curl sobre la homepage de la tienda multilang
warmupHomepage();

//Curl sobre las categorias principales de la tienda multilang
warmupCategories();


function warmupHomepage()
{
    $languages = \Language::getLanguages();
    $link = new \Link();
    $domainShop = rtrim($link->getBaseLink(), '/');
    echo date('Y-m-d H:i:s')." - Starting warmup for domain: $domainShop\r\n";

    foreach ($languages as $language) {
        $url = $domainShop.'/index.php?id_lang='.$language['id_lang'];
        sendRequest($url);
    }
}

function warmupCategories()
{
    $categories = \Db::getInstance()->query('select id_category from '._DB_PREFIX_.'category where id_parent = 2;');
    $link = new \Link();
    $languages = \Language::getLanguages();

    while ($category = $categories->fetch()) {
        $categoria = new \Category($category['id_category']);

        foreach ($languages as $language) {
            $url = $link->getCategoryLink($categoria, true, $language['id_lang']);
            sendRequest($url);
        }
    }
}

function sendRequest($url)
{
    echo date('Y-m-d H:i:s')." - Sending request for: $url\r\n";

    $ch = curl_init($url);
    //Establecer un tiempo de espera
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

    //Permitir seguir redireccionamientos
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //recibir la respuesta como string, no output
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    //Obtener el código de respuesta
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo date('Y-m-d H:i:s')." - $httpcode - $url\r\n";

    //cerrar conexión
    curl_close($ch);
}