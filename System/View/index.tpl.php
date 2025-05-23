StockMarket-Project
<br>
<?php
foreach ($this->data['resources'] as $key => $data) {
    ?>
    <strong>
        <?=$key?>.
        <?=$data['url']?>
    </strong>
    <br>
    Metoda: <?=$data['method']?>
    <br>
    <?= $data['description']?>
    <br>

<?php } ?>
