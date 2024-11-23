<?php

try{
    require 'db.inc.php';

    $tabela0 = 'CREATE TABLE IF NOT EXISTS categories(
        category_id int primary key auto_increment,
        category_name varchar(255) not null
    )';

    $pdo->exec($tabela0);

    $table1 = 'CREATE TABLE IF NOT EXISTS products(
        product_id int primary key auto_increment,
        product_category int not null,
        product_name varchar(255) not null,
        product_image varchar(255) not null,
        product_price decimal(10,2) not null,

        FOREIGN KEY (product_category) REFERENCES categories(category_id) ON UPDATE CASCADE ON DELETE CASCADE

    )';

    $pdo->exec($table1);

    $tabela2 = 'CREATE TABLE IF NOT EXISTS orders(
        order_id int primary key auto_increment,
        id_product int not null,
        id_user int not null,
        order_quantity int not null,
        order_completion ENUM("Pending","Accepted","Failed") DEFAULT "Pending",

        FOREIGN KEY (id_product) REFERENCES products(product_id) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
    )';

    $pdo->exec($tabela2);

    $tabela3 = 'CREATE TABLE IF NOT EXISTS cart(
        cart_id int primary key auto_increment,
        id_order int not null,

        FOREIGN KEY (id_order) REFERENCES orders(order_id) ON UPDATE CASCADE ON DELETE CASCADE
    )';

    $pdo->exec($tabela3);

} catch(PDOException $e){
    die('Failed Because Of ' . $e->getMessage());
}

?>