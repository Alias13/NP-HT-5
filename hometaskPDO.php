<?php
$user = 'root';
$pass = '';
try {
    $dbh = new PDO('mysql:host=localhost; dbname=test; charset=UTF8', $user, $pass);
    echo "Подключились\n";
} catch (Exception $e) {
    die("Не удалось подключиться: " . $e->getMessage());
}
var_dump($dbh);

try{
    $dbh->exec('SET NAMES utf8');
    $stmt = $dbh->exec("CREATE TABLE CLIENTS 
                  (id     int       NOT NULL AUTO_INCREMENT,
                   FIO      varchar(40)  NOT NULL,
                   ADDR     varchar(30)  NOT NULL, 
                   CITY     varchar(15)  NOT NULL, 
                   PHONE    varchar(11)  NOT NULL,
                   PRIMARY KEY (id)) CHARACTER SET utf8 COLLATE utf8_general_ci");
}
catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}

try{
    $stmt = $dbh->exec("CREATE TABLE TOOLS
                  (id   int          NOT NULL AUTO_INCREMENT, 
                   DSEC  varchar(40)     NOT NULL, 
                   PRICE  double(9,2)  NOT NULL, 
                   QUANTITY    double(9,2)  NOT NULL,
                   PRIMARY KEY (id)) CHARACTER SET utf8 COLLATE utf8_general_ci");
}
catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}

try{
    $stmt = $dbh->exec("CREATE TABLE ORDERS
                  (id     int         NOT NULL AUTO_INCREMENT,
                   DATE     date        NOT NULL,
                   id_client     int         NOT NULL, 
                   id_tools     int         NOT NULL, 
                   QUANTITY double(9,2) NOT NULL, 
                   AMOUNT   double(9,2) NOT NULL,
                   PRIMARY KEY (id)) CHARACTER SET utf8 COLLATE utf8_general_ci");
}
catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}

//INSERT INTO `ORDERS` (`id`, `DATE`, `id_client`, `id_tools`, `QUANTITY`, `AMOUNT`) VALUES (NULL, '2016-10-01', '1', '1', '3', '1500'), (NULL, '2016-10-03', '2', '2', '1', '200');
try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $dbh->beginTransaction();
    $dbh->exec('SET NAMES utf8');
    $dbh->exec("INSERT INTO `CLIENTS` 
                (`id`, `FIO`, `ADDR`, `CITY`, `PHONE`) 
                VALUES (NULL, 'Петров И. И.', 'Решельевская 50', 'Одесса', '0631223345'),
                       (NULL, 'Иванов И. И.', 'Греческая 4', 'Одесса', '0631345345'),
                       (NULL, 'Иванчук И. И.', 'Крещатик 34', 'Киев', '0639873545'),
                       (NULL, 'Сидоров И. И.', 'Бунина 12', 'Одесса', '0631223348')");
    $dbh->commit();

} catch (Exception $e) {
    $dbh->rollBack();
    echo "Ошибка: " . $e->getMessage();
}

try {
    $dbh->beginTransaction();

    $stmt = $dbh->exec("INSERT INTO `ORDERS` (`id`, `DATE`, `id_client`, `id_tools`, `QUANTITY`, `AMOUNT`) 
                       VALUES (NULL, '2016-10-01', '1', '1', '3', '1500'), 
                              (NULL, '2016-10-03', '2', '2', '5', '2000'),
                              (NULL, '2016-10-04', '2', '3', '2', '1000'),
                              (NULL, '2016-10-03', '3', '3', '6', '1200'),
                              (NULL, '2016-10-05', '4', '4', '1', '3000')");

    /*$stmt = $dbh->prepare("INSERT INTO `ORDERS` (id, DATA , id_client, id_tools, QUANTITY, AMOUNT)
                       VALUES (:id, :DATA , :id_client, :id_tools, :QUANTITY, :AMOUNT)");*/

    /*  $stmt->bindParam(':id', $id);
        $stmt->bindParam(':DATA', $data);
        $stmt->bindParam(':id_client', $id_client);
        $stmt->bindParam(':id_tool', $id_tool);
        $stmt->bindParam(':QUANTITY', $QUANTITY);
        $stmt->bindParam(':AMOUNT', $AMOUNT);

    // вставим одну строку
        $id = 'NULL';
        $data = '2016-10-01';
        $id_client = '1';
        $id_tool = '1';
        $QUANTITY = '3';
        $AMOUNT = '1500';
        $stmt->execute();

    // теперь другую строку с другими значениями
        $id = 'NULL';
        $data = '2016-10-03';
        $id_client = '2';
        $id_tool = '2';
        $QUANTITY = '1';
        $AMOUNT = '300';
        $stmt->execute();

    // теперь другую строку с другими значениями
        $id = 'NULL';
        $data = '2016-10-04';
        $id_client = '3';
        $id_tool = '4';
        $QUANTITY = '6';
        $AMOUNT = '600';
        $stmt->execute();

    // теперь другую строку с другими значениями
        $id = 'NULL';
        $data = '2016-10-05';
        $id_client = '3';
        $id_tool = '4';
        $QUANTITY = '2';
        $AMOUNT = '200';
        $stmt->execute();*/

    $dbh->commit();

} catch (Exception $e) {
    $dbh->rollBack();
    echo "Ошибка: " . $e->getMessage();
}
//INSERT INTO `TOOLS` (`id`, `DSEC`, `PRICE`, `QUANTITY`) VALUES (NULL, 'Описание', '200', '2'), (NULL, 'Тоже описание', '150', '5');

try {
    $dbh->beginTransaction();
    $stmt = $dbh->exec("INSERT INTO `TOOLS` (`id`, `DSEC`, `PRICE`, `QUANTITY`) 
                        VALUES (NULL, 'Описание', '200', '2'), 
                              (NULL, 'Тоже описание', '150', '3'),
                              (NULL, 'Еще одно описание', '300', '5'),
                              (NULL, 'Опять описание', '250', '5')");
    $dbh->commit();

} catch (Exception $e) {
    $dbh->rollBack();
    echo "Ошибка: " . $e->getMessage();
}