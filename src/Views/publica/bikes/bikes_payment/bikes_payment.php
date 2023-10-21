<?=$this->fetch('../../common/header.php', $data)?>
<style>
    body {
        background: #fff;
        color: #000;
    }
</style>

<section class="payment-container">
    <img src="data:image/png;base64, <?=base64_encode($data['informacoes']['image'])?>">
    <br>
    <strong><?=$data['informacoes']['payload']?></strong>
</section>


<?=$this->fetch('../../common/footer.php')?>