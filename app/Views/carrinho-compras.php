<?= $this->extend("templates/layoutSite"); ?>

<?= $this->section("conteudo") ?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-left">
                <h1 style="color: #384aeb;">Carrinho de compras</h1>
            </div>
        </div>
    </div>
</section>

<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Quantidade</th>
                            <th style="width: 118px !important" scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                            $aCarrinho      = session()->get("Carrinho");
                            $aCarrinhoItens = session()->get("CarrinhoItens");
                            $subTotal       = 0;
                            $totalFinal     = 0;
                            $tipoFrete      = 0;

                            if (!is_null($aCarrinho)) {
                                if ($aCarrinho['tipoFrete'] == 1) {
                                    $tipoFrete      = 1;
                                } elseif ($aCarrinho['tipoFrete'] == 2) {
                                    $tipoFrete      = 2;
                                    $totalFinal     = 15;
                                }

                            }

                            if (is_null($aCarrinhoItens)) {
                                $aCarrinhoItens = [];
                            }

                            if (count($aCarrinhoItens) == 0) {
                                ?>
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center">Seu carrinho está vazio!</p>
                                    </td>
                                </tr>
                                <?php
                            } else {

                                foreach ($aCarrinhoItens AS $produto) {
                                    ?>

                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="<?= base_url('uploads/produto/' . $produto['imagem']) ?>" style="width: 100px; height: 100px" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <p><?= $produto['descricao'] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>R$ <?= formatValor($produto['valorUnitario']) ?></h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                                <input type="text" name="quantidade_<?= $produto['produto_id'] ?>" id="quantidade_<?= $produto['produto_id'] ?>" maxlength="12" value="<?= formatValor($produto['quantidade'], 0) ?>" title="Quantidade"
                                                    class="input-text qty">
                                                <button
                                                    onclick="atualizaQuantidade(1, <?= $produto['produto_id'] ?>, <?= $produto['valorUnitario'] ?>)"
                                                    class="increase items-count" type="button"><i
                                                        class="ti ti-angle-up"></i></button>
                                                <button
                                                    onclick="atualizaQuantidade(0, <?= $produto['produto_id'] ?>, <?= $produto['valorUnitario'] ?>)"
                                                    class="reduced items-count" type="button"><i
                                                        class="ti ti-angle-down"></i></button>
                                            </div>
                                        </td>
                                        <td>
                                            <h5 id="totalItem_<?= $produto['produto_id'] ?>">R$ <?= formatValor($produto['valorTotal']) ?></h5>
                                        </td>
                                    </tr>

                                    <?php

                                    $subTotal += $produto['valorTotal'];
                                    $totalFinal += $produto['valorTotal'];
                                }
                            }
                        ?>

                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td style="width: 150px !important;">
                                <h5 id="subTotal">R$ <?= formatValor($subTotal) ?></h5>
                            </td>
                        </tr>
                        <tr class="shipping_area">
                            <td class="d-none d-md-block">
                            </td>
                            <td>
                            </td>
                            <td>
                                <h5>Frete</h5>
                            </td>
                            <td>
                                <div class="shipping_box">
                                    <ul class="list">
                                        <li id="tipoFrete1" <?= ($tipoFrete == 1 ? 'class="active"' : '') ?>><a onclick="selecionaFrete(1)">Frete grátis</a></li>
                                        <li id="tipoFrete2" <?= ($tipoFrete == 2 ? 'class="active"' : '') ?>><a onclick="selecionaFrete(2)">SEDEX: R$ 15,00</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                <h5>Total</h5>
                            </td>
                            <td style="width: 150px !important;">
                                <h5 id="totalFinal">R$ <?= formatValor($totalFinal) ?></h5>
                            </td>
                        </tr>

                        <tr class="out_button_area">
                            <td class="d-none-l">
                            </td>
                            <td class="">
                            </td>
                            <td>
                            </td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="index.php">Continue comprando</a>
                                    <a id="btnPagamento" class="primary-btn ml-2 <?= ($tipoFrete == 0 ? 'disabled' : '') ?>" href="<?= base_url() ?>carrinhoPagamento">Pagamento</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    function atualizaQuantidade(tipo, produto_id, valorUnitario) {

        var quantidade  = document.getElementById('quantidade_' + parseInt(produto_id));
        var subTotal    = parseFloat(document.getElementById('subTotal').innerHTML.replaceAll(".", "").replaceAll(",",".").replaceAll("R$ ", ""));
        var totalFinal  = parseFloat(document.getElementById('totalFinal').innerHTML.replaceAll(".", "").replaceAll(",",".").replaceAll("R$ ", ""));
        var baseURL = location.protocol + "//" + location.hostname;

        if (tipo == 0) {
            quantidade.value = parseFloat(quantidade.value) - 1;
            subTotal -= valorUnitario;
            totalFinal -= valorUnitario;
        } else {
            quantidade.value = parseFloat(quantidade.value) + 1;
            subTotal += valorUnitario;
            totalFinal += valorUnitario;
        }

        itemValorTotal = quantidade.value * valorUnitario;
        
        document.getElementById('totalItem_' + parseInt(produto_id)).innerHTML = "R$ " + itemValorTotal.toLocaleString('pt-br',{minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('subTotal').innerHTML = "R$ " + subTotal.toLocaleString('pt-br',{minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('totalFinal').innerHTML = "R$ " + totalFinal.toLocaleString('pt-br',{minimumFractionDigits: 2, maximumFractionDigits: 2});

        $.ajax({
            method: "POST",
            url: "<?= base_url() ?>atualizaProdutoCarrinho",
            data: {"produto_id":produto_id, "quantidade":quantidade.value},
            success: function(data) {
            }
        });

        if ((subTotal == 0) || (quantidade.value == 0)) {
            window.location.href = baseURL + '/carrinhoCompras';
        }
    }

    function selecionaFrete(tipoFrete) {

        var totalFinal  = parseFloat(document.getElementById('totalFinal').innerHTML.replaceAll(".", "").replaceAll(",",".").replaceAll("R$ ", ""));

        if (tipoFrete == 1) {
            document.getElementById('tipoFrete1').className = "active";
            document.getElementById('tipoFrete2').className = "";
            totalFinal -= 15

        } else {
            document.getElementById('tipoFrete1').className = "";
            document.getElementById('tipoFrete2').className = "active";
            totalFinal += 15
        }

        document.getElementById('totalFinal').innerHTML = "R$ " + totalFinal.toLocaleString('pt-br',{minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('btnPagamento').className = "primary-btn ml-2";

        $.ajax({
            method: "POST",
            url: "<?= base_url() ?>atualizaFrete",
            data: {"tipoFrete":tipoFrete},
            success: function(data) {
            }
        });
    }

</script>

<?= $this->endSection() ?>