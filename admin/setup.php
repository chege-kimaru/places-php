<?php
require_once __DIR__ . "/bootstrap.php";

$db->beginTransaction();

try {
    $createProduct = $db->exec("CREATE TABLE places (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    price INT(11),
    description VARCHAR(3000),
    location VARCHAR(255),
    image VARCHAR(255),
    map VARCHAR(255),
    phone VARCHAR(255),
    website VARCHAR(255),
    featured INT(1),
    status INT(1),
    created_at datetime DEFAULT CURRENT_TIMESTAMP
    )");
    
    $createProductImage = $db->exec("CREATE TABLE place_images (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    place_id INT(11) NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (place_id) REFERENCES places(id)
    )");

    $db->commit();
//    header('location: index.php');
    echo "<h1>Done</h1>";

} catch (\Exception $e) {

    $db->rollBack();

    if ($e->getCode() == '42S01') {
//        header('location: index.php');
        echo "<h1>Done with code</h1>";
    }

    echo $e->getMessage();
}