StockMarket-Project <br> <br>
Current page: <?= isset($_GET['page']) ? $_GET['page'] : 'Index' ?> <br><br>

<?php
foreach ($this->data['resources'] as $key => $data) {
    ?>
    <strong>
        <?=$key?>.
        <?=$data['url']?>
    </strong>
    <br>
    Metoda: <?=$data['method']?><br>
    <?= $data['description']?> <br> <br>

<?php } ?>
