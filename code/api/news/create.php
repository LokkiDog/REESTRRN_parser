<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: http://parser");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// получаем соединение с базой данных 
include_once '../config/database.php';

// создание объекта товара 
include_once '../objects/news.php';
include_once '../functions.php';

// use functions\time_format;


$database = new Database();
$db = $database->getConnection();

$news = new News($db);
 
// получаем отправленные данные 
$data = $_POST;
$files = $_FILES;

// убеждаемся, что данные не пусты 
if (
    !empty($data['title']) &&
    !empty($data['time']) &&
    (!empty($data['link']) || !empty($data['site_link']))
) {
    $data = (Object)$data;
    $files = (Object)$files;

    // Если нет ссылки на новость, то ставим ссылку на сайт
    if (!$data->link && $data->site_link) {
        $news->link = $data->site_link;
    } else {
        $news->link = $data->link;
    }


    // устанавливаем значения
    $news->title = $data->title;
    $news->description = $data->description;
    $news->site_link = $data->site_link;
    $news->time = time_format($data->time);


    // создание новости \ добавление в БД 
    if($news->create()){

        // установим код ответа - 201 создано 
        http_response_code(201);

        // сообщим пользователю 
        echo json_encode(array("message" => "Новость успешно добавлена."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю 
    else {

        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("message" => "При добавлении произошла ошибка."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("message" => "Невозможно добавить новость. Данные неполные."), JSON_UNESCAPED_UNICODE);
}



?>