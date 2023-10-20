<?=$this->fetch('../common/header.php', $data)?>

<section class="container hero pt-5">
      <div class="container">
        <div class="row gutter-2 gutter-md-4 justify-content-between">

          <div class="col-lg-7">
            <div class="row gutter-1 justify-content-between">
              <div class="col-lg-2 text-center text-lg-left order-lg-1">
                <div class="owl-thumbs" data-slider-id="1">
                    <span class="owl-thumb-item"><img src="<?=URL_BASE.$data['informacoes']['bicicleta']['imagem_principal_bicicleta']?>" alt=""></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5 mb-5 mb-lg-0">
            <div class="row">
              <div class="col-12">
                <h1 class="item-title"><?=$data['informacoes']['bicicleta']['nome_bicicleta']?></h1>
                <span class="item-price">R$ <?=$data['informacoes']['bicicleta']['preco_bicicleta']?></span>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <p><?=$data['informacoes']['bicicleta']['descricao_bicicleta']?></p>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-12">
                <div class="form-group">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <a href="<?=URL_BASE?>bikes/payment/<?=$data['informacoes']['bicicleta']['id_bicicleta']?>" class="btn btn-block btn-lg btn-primary">Alugar bicicleta</a>
              </div>
              <div class="col-12 mt-1">
              </div>
              <div class="row mt-4 ml-2">
              <div class="col-12 ">
                <h2 class="vendedor">Vendedor</h2>
                <span class="name-vendedor"><b><?=$data['informacoes']['vendedor']['nome_usuario']?></b></span>
                <span class="vendedor-telefone"></span>
              </div>
            </div>
          </div>
            
        </div>
      </div>
    </section>

    

<?=$this->fetch('../common/footer.php')?>