<?php

function exibeTitulo(
    $titulo, 
    $parametro = ['acao' => 'lista']
) {
    ?>
    <section>
        <div class="blog-banner">
            <div class="row">
                <div class="col-10 mt-5 mb-5 text-left">
                    <h1 style="color: #384aeb;">subtitulo</h1>
                </div>
                <div class="col-2 mt-5 mb-5 text-right">
                    <a href="#" class="btn btn-secondary btn-sm btn-icons-crud" title="Novo"><i class="fa fa-????" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </section>
    <?php

    return "<h2>" . $titulo . "</h2>";
}

/**
 * mensagemSucesso
 *
 * @return string
 */
function mensagemSucesso()
{
    $texto = '  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>mensagem de sucesso</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';

    return $texto;
}

/**
 * mensagemError
 *
 * @return string
 */
function mensagemError()
{
    $texto = '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Mensagem de error</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';

    return $texto;
}

/**
 * setMsgErrorCampo
 *
 * @return string
 */
function setMsgErrorCampo()
{
    $texto = 'div class="text-danger mt-2">mensagem de error no campo</div>';

    return $texto;
}

/**
 * comboboxStatus
 *
 * @param int $status 
 * @return string
 */
function comboboxStatus($status = 0)
{
    return '<label for="statusRegistro" class="form-label">Status</label>
            <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                <option value=""  ' . (isset($status) ? ($status == 0 ? "selected" : "") : "") . '>...</option>
                <option value="1" ' . (isset($status) ? ($status == 1 ? "selected" : "") : "") . '>Ativo</option>
                <option value="2" ' . (isset($status) ? ($status == 2 ? "selected" : "") : "") . '>Inativo</option>
            </select>';
}
