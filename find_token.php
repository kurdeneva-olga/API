<?php

// Проверка на существование ГЕТ параметров
if(!isset($_GET)){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Вы не указали GET параметры", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

// Проверка на существование ГЕТ параметра token
if(!isset($_GET['token'])){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Вы не указали GET параметр token", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

define('TOKEN', $_GET['token']);

if(!preg_match_all("/^[A-z0-9_]{32}$/iu", TOKEN)){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Ваш токен не соответствует шаблону", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

$query = "SELECT COUNT(`id`) > 0 AS 'RESULT' FROM `tokens` WHERE `token` = '" . TOKEN . "' AND `ban` = FALSE";
$res_query = mysqli_query($connection, $query);

if(!$res_query){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Ошибка в запросе!!!.", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

$res = mysqli_fetch_assoc($res_query);

if(!$res){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Ошибка в запросе.", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

if($res['RESULT'] == '0'){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Ваш токен не является действительным!", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

//объявление id токена

    $querytoken = "SELECT `id` FROM `tokens` WHERE `token` = '". TOKEN. "'";
    $res_query1 = mysqli_query($connection, $querytoken);

    if(!$res_query1){
        echo ajax_echo(
            "Ошибка!", 
            "Request error.", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }
    $row = mysqli_fetch_assoc($res_query1);
	define('IDTOKEN', $row["id"]);


