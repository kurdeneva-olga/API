<?php 

include_once("config.php");
include_once("db_connect.php");
include_once("functions.php");
include_once("find_token.php");

if(!isset($_GET['type'])) {
    echo ajax_echo(
        "Ошибка!", 
        "Вы не указали GET параметр type", 
        true, 
        "ERROR", 
        null 
    );
    exit();
}

if(preg_match_all("/^(list_product)$/ui", $_GET['type'])){
    $query = "SELECT `products`.`id`, `products`.`name`, `articul`, `categories`.`name` AS 'category', `cost` FROM `products` INNER JOIN `categories` ON `id_category` = `categories`.`id`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Request error.", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }
    
    echo ajax_echo(
        "Список товаров", 
        "Вывод списка товаров", 
        false, 
        "SUCCESS", 
        $arr_list 
    );
    exit();
}

if(preg_match_all("/^(list_orders)$/ui", $_GET['type'])){
    $subquery = "SELECT `status` FROM `tokens` WHERE token ='".TOKEN."'";
    $res = mysqli_query($connection, $subquery);
    $row = mysqli_fetch_assoc($res);
    if($row['status'] == 'администратор')
    {
        $query = "SELECT `id_token`, `products`.`name`,  `date` FROM `orders` INNER JOIN `products` ON `id_product` = `products`.`id`";
        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!", 
                "Request error.", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }

        $arr_list = array();
        $rows = mysqli_num_rows($res_query);

        for ($i=0; $i < $rows; $i++) { 
            $row = mysqli_fetch_assoc($res_query);
            array_push($arr_list, $row);
        }
        
        echo ajax_echo(
            "Список заказов", 
            "Вывод списка заказов", 
            false, 
            "SUCCESS", 
            $arr_list 
        );
        exit();
    }
    else{
        $query = "SELECT `products`.`name`,  `date` FROM `orders` INNER JOIN `products` ON `id_product` = `products`.`id`  WHERE id_token = '".IDTOKEN."'";
        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!", 
                "Request error.", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }

        $arr_list = array();
        $rows = mysqli_num_rows($res_query);

        for ($i=0; $i < $rows; $i++) { 
            $row = mysqli_fetch_assoc($res_query);
            array_push($arr_list, $row);
        }
        
        echo ajax_echo(
            "Список заказов пользователя", 
            "Вывод списка заказов пользователя", 
            false, 
            "SUCCESS", 
            $arr_list 
        );
        exit();
    }
}

if(preg_match_all("/^(list_users)$/ui", $_GET['type'])){

    $subquery = "SELECT `status` FROM `tokens` WHERE token ='".TOKEN."'";
    $res = mysqli_query($connection, $subquery);
    $row = mysqli_fetch_assoc($res);
    if($row['status'] == 'администратор')
    {
        $query = "SELECT `id`, `second_name`, `first_name`, `middle_name`, `gender` FROM `users`";
        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!", 
                "Request error.", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }

        $arr_list = array();
        $rows = mysqli_num_rows($res_query);

        for ($i=0; $i < $rows; $i++) { 
            $row = mysqli_fetch_assoc($res_query);
            array_push($arr_list, $row);
        }
        
        echo ajax_echo(
            "Список заказов пользователя", 
            "Вывод списка заказов пользователя", 
            false, 
            "SUCCESS", 
            $arr_list 
        );
        exit();
    }
    else{        
        echo ("Вы не обладаете необходимыми правами");
            exit();
    } 
}

if(preg_match_all("/^(list_cart)$/ui", $_GET['type'])){
    $subquery = "SELECT `status` FROM `tokens` WHERE token ='".TOKEN."'";
    $res = mysqli_query($connection, $subquery);
    $row = mysqli_fetch_assoc($res);
    if($row['status'] == 'администратор')
    {
        $query = "SELECT `id_token`, `products`.`name`, `date_of_append` FROM `cart` INNER JOIN `products` ON `id_product` = `products`.`id`";
        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Request error.", 
                true, 
                "ERROR",
                null 
            );
            exit();
        }

        $arr_list = array();
        $rows = mysqli_num_rows($res_query);

        for ($i=0; $i < $rows; $i++) { 
            $row = mysqli_fetch_assoc($res_query);
            array_push($arr_list, $row);
        }
        
        echo ajax_echo(
            "Список продукции в корзине пользователя",
            "Вывод списка продуктов из корзины", 
            false,
            "SUCCESS",
            $arr_list
        );
        exit();
    }
    else{
        $query = "SELECT `products`.`name`, `date_of_append` FROM `cart` INNER JOIN `products` ON `id_product` = `products`.`id` WHERE id_token = '".IDTOKEN."'";
        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Request error.", 
                true, 
                "ERROR",
                null 
            );
            exit();
        }

        $arr_list = array();
        $rows = mysqli_num_rows($res_query);

        for ($i=0; $i < $rows; $i++) { 
            $row = mysqli_fetch_assoc($res_query);
            array_push($arr_list, $row);
        }
        
        echo ajax_echo(
            "Список продукции в корзине пользователя",
            "Вывод списка продуктов из корзины", 
            false,
            "SUCCESS",
            $arr_list
        );
        exit();
    }
}

if(preg_match_all("/^(list_comments)$/ui", $_GET['type']))
{
    $query = "SELECT `comments`.`id`, `products`.`name`, `comment` FROM `comments` INNER JOIN `products` ON `id_product` = `products`.`id`";
    $res_query = mysqli_query($connection, $query);
    
        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Request error.",
                true, 
                "ERROR", 
                null 
            );
            exit();
        }
    
        $arr_list = array();
        $rows = mysqli_num_rows($res_query);
    
        for ($i=0; $i < $rows; $i++) { 
            $row = mysqli_fetch_assoc($res_query);
            array_push($arr_list, $row);
        }   
        
        echo ajax_echo(
            "Список отзывов", 
            "Вывод списка отзывов", 
            false, 
            "SUCCESS", 
            $arr_list
        );    
        exit();
}

if(preg_match_all("/^(add_product)$/ui", $_GET['type'])){
    $subquery = "SELECT `status` FROM `tokens` WHERE token ='".TOKEN."'";
    $res = mysqli_query($connection, $subquery);
    $row = mysqli_fetch_assoc($res);
    if($row['status'] == 'администратор')
    {
        $query = "INSERT INTO `products`(";
        
        if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){
            $query .= "`name`,";
        }
        else{
            echo ajax_echo(
                "Ошибка!", 
                "Вы не указали GET параметр name", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }

        if(isset($_GET['articul']) && iconv_strlen($_GET['articul']) > 0){
            $query .= "`articul`,";
        }

        if(isset($_GET['id_category']) && iconv_strlen($_GET['id_category']) > 0){
            $query .= "`id_category`,";
        }
        else{
            echo ajax_echo(
                "Ошибка!", 
                "Вы не указали GET параметр id_category", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }

        if(isset($_GET['cost']) && iconv_strlen($_GET['cost']) > 0){
            $query .= "`cost`";
        }
        else{
            echo ajax_echo(
                "Ошибка!", 
                "Вы не указали GET параметр cost", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }
    
    
    $query .= ") VALUES (";
    
    if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){
        $query .= "'".$_GET['name']."',";
    }

    if(isset($_GET['articul']) && iconv_strlen($_GET['articul']) > 0){
        $query .= "'".$_GET['articul']."',";
    }

    if(isset($_GET['id_category']) && iconv_strlen($_GET['id_category']) > 0){
        $query .= "'".$_GET['id_category']."',";
    }

    if(isset($_GET['cost']) && iconv_strlen($_GET['cost']) > 0){
        $query .= "'".$_GET['cost']."'";
    }
    
    $query .= ")";

        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Ошибка в запросе!!!",
                true,
                "ERROR",
                null
            );
            exit();
        }
    
        echo ajax_echo(
            "Успех!",
            "Новый товар был добавлен в базу данных!",
            false, 
            "SUCCESS", 
            null
        );
        exit();
    }
    else{
        echo ("Вы не обладаете необходимыми правами!");
        exit();
    }
}

if(preg_match_all("/^(add_comment)$/ui", $_GET['type']))
{
    $query = "INSERT INTO `comments` (`id_token`, "; 

    if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){
        $query .= "`id_product`, ";
    }
    else{
        echo ajax_echo(
            "Ошибка!", 
            "Вы не указали GET параметр name", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    if(isset($_GET['comment']) && iconv_strlen($_GET['comment']) > 0){
        $query .= "`comment` ";
    }

    $query .= ") VALUES ('".IDTOKEN."', ";

    if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){        
        $subquery = "SELECT `id` FROM `products` WHERE `name` = '".$_GET['name']."'";
        $res = mysqli_query($connection, $subquery);
        $row = mysqli_fetch_assoc($res);  

        if($row['id'] == NULL){
            echo ajax_echo(
                "Ошибка!", 
                "This product is not on the list!", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }
        $query .= "'".$row["id"]."', ";
    }

    if(isset($_GET['comment']) && iconv_strlen($_GET['comment']) > 0){
        $query .= "'".$_GET['comment']."'";
    }

    $query .=")";

    $res_query = mysqli_query($connection, $query);
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "Новый отзыв был добавлен в базу данных!", 
        false, 
        "SUCCESS", 
        null 
    );
    exit();
}

if(preg_match_all("/^(add_order)$/ui", $_GET['type']))
{
    $query = "INSERT INTO `orders`( `id_token`, "; 

    if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){
        $query .= "`id_product`";
    }
    else{
        echo ajax_echo(
            "Ошибка!", 
            "Вы не указали GET параметр name", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    $query .= ") VALUES ('".IDTOKEN."', ";

    if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){
        $subquery = "SELECT `id` FROM `products` WHERE `name` = '".$_GET['name']."'";
        $res = mysqli_query($connection, $subquery);

        $row = mysqli_fetch_assoc($res);        
        if($row['id'] == NULL){
            echo ajax_echo(
                "Ошибка!", 
                "This product is not on the list!", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }
        $query .= "'".$row["id"]."'";   
    }
    $query .=")";

    $res_query = mysqli_query($connection, $query);
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "Новый заказ был добавлен в базу данных!", 
        false, 
        "SUCCESS", 
        null 
    );
    exit();
}

if(preg_match_all("/^(upd_product)$/ui", $_GET['type']))
{
    $query = "UPDATE `products` SET "; 

   if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){
        $query .= "`name` ='".$_GET['name']."'";   
    }

    if(isset($_GET['articul']) && iconv_strlen($_GET['articul']) > 0){
        if(isset($_GET['name']))
            $query .= ", ";
        $query .= "`articul`='".$_GET['articul']."'";
    }

    if(isset($_GET['category']) && iconv_strlen($_GET['category']) > 0){
        if(isset($_GET['name']) || $_GET['articul'])
            $query .= ", ";
        $query .= "`, id_category` ='".$_GET['id_category']."'";
    }

    if(isset($_GET['cost']) && iconv_strlen($_GET['cost']) > 0){
        if(isset($_GET['name']) || isset ($_GET['articul']) || isset ($_GET['category']))
            $query .= ", ";
        $query .= "`cost` = '".$_GET['cost']."'";
    }

    $query .="WHERE ";

    if(isset($_GET['id_product']) && iconv_strlen($_GET['id_product']) > 0){
        $query .="id = '".$_GET['id_product']."'";
    }

    $res_query = mysqli_query($connection, $query);
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    echo ajax_echo(
        "Успех!",
        "Товар был обновлен в базе данных!",
        false, 
        "SUCCESS",
        null 
    );
    exit();
}

if(preg_match_all("/^(upd_comm)$/ui", $_GET['type']))
{
    $query = "UPDATE `comments` SET "; 

   if(isset($_GET['name']) && iconv_strlen($_GET['name']) > 0){
        $subquery = "SELECT `id` FROM `products` WHERE `name` = '".$_GET['name']."'";
        $res = mysqli_query($connection, $subquery);
        $row = mysqli_fetch_assoc($res); 

        if($row['id'] == NULL){
            echo ajax_echo(
                "Ошибка!", 
                "This product is not on the list!", 
                true, 
                "ERROR", 
                null 
            );
            exit();
        }
        $query .= "`id_product` ='".$row["id"]."'";       
    }

    if(isset($_GET['comm']) && iconv_strlen($_GET['comm']) > 0){
        if(isset($_GET['product']))
            $query .= ", ";
        $query .= "`comment`='".$_GET['comm']."'";
    }

    $query .="WHERE ";

    if(isset($_GET['id_com']) && iconv_strlen($_GET['id_com']) > 0){
        $query .="id = '".$_GET['id_com']."'";
    }

    $res_query = mysqli_query($connection, $query);
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    echo ajax_echo(
        "Успех!",
        "Отзыв был обновлен в базе данных!", 
        false, 
        "SUCCESS",
        null 
    );
    exit();
}

if(preg_match_all("/^(upd_user)$/ui", $_GET['type']))
{
    $subquery ="SELECT `id` FROM `tokens` WHERE token ='".TOKEN."'";
    $res = mysqli_query($connection, $subquery);
    $row = mysqli_fetch_assoc($res);

    $query = "UPDATE `users` SET "; 

    if(isset($_GET['sec_n']) && iconv_strlen($_GET['sec_n']) > 0){
        $query .= "`second_name`='".$_GET['sec_n']."'";
    }

    if(isset($_GET['first_n']) && iconv_strlen($_GET['first_n']) > 0){
        if(isset($_GET['sec_n']))
            $query .= ", ";
        $query .= "`first_name`='".$_GET['first_n']."'";
    }

    if(isset($_GET['mid_n']) && iconv_strlen($_GET['mid_n']) > 0){
        if(isset($_GET['sec_n']) || isset($_GET['first_n']))
            $query .= ", ";
        $query .= "`middle_name`='".$_GET['mid_n']."'";
    }

    $query .="WHERE `id` = '".$row["id"]."'";

    $res_query = mysqli_query($connection, $query);
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!", 
            true, 
            "ERROR", 
            null 
        );
        exit();
    }

    echo ajax_echo(
        "Успех!",
        "Данные о пользователе были обновлены в базе данных!", 
        false, 
        "SUCCESS",
        null 
    );
    exit();
} 