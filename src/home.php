<?php 
use d17030752\Stock\models\Stock;
require_once 'src/models/Stock.php';
if (isset($_POST['name'])) {
    # code...
    $name =$_POST['name'];
    if (!Stock::existsOnDb($name)) {
        # code...
        $stock = new Stock($name);
        if ($stock->isStockReal()) {
            # code...
            $stock->save();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="src/resources/main.css">
</head>
<body>
    <div class="container">
        
    <h1>Home</h1>
    <form action="" method="POST">
        <input type="text" name="name" id="">
        <input type="submit" name="" id="" value="add stock">
    </form>
    <div class="stocks">
        <?php 
        $stocks=Stock::getAll();
        foreach ($stocks as $stock) {
            # code...
            echo "<div class='stock'>
                <div>{$stock->getTicker()}</div>
                <div>{$stock->getName()}</div>
                <div>$ {$stock->getStock()->lastPrice}</div>
            </div>";
        }
        ?>
    </div>
    </div>
</body>
</html>