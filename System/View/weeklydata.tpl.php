StockMarket-Project <br> <br>
Current page: <?= isset($_GET['page']) ? $_GET['page'] : 'Index' ?> <br><br>

<?php
foreach ($this->data['resources'] as $key => $data) {
    ?>
    <strong>
        <?=$key?>.
        URL: <?=$data['url']?>
    </strong>
    <br>
    Method: <?=$data['method']?>
    <br>
    Description: <?= $data['description']?> <br>
    <br>
<?php } ?>
