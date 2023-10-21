<?=$this->fetch('../common/header.php', $data)?>

<div class="container text-center">
  <div class="row">
    <?php
      foreach ($data['informacoes']['lista'] as $bicicleta) {?>
        <div class="bike-card col g-col-6 g-col-md-4">
        <div class="img-div">
          <span class="img-shadow"><span>Clique no botão para ver mais</span></span>
          <img src="<?=URL_BASE.$bicicleta['imagem_principal_bicicleta']?>" class="card-img-top">
        </div>
        <div class="card-body">
          <h5 class="card-title"><?=$bicicleta['nome_bicicleta']?></h5>
          <p class="card-price">R$ <?=$bicicleta['preco_bicicleta']?></p>
          <!-- <p class="card-name"><?=$bicicleta['vendedor_bicicleta']?></p> -->
          <a href="<?=URL_BASE?>bikes/<?=$bicicleta['id_bicicleta']?>" class="btn btn-primary">Ver bicicleta</a>
        </div>
      </div>
    <?php }?>
  </div>
</div>

<?=$this->fetch('../common/footer.php')?>