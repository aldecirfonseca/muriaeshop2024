<main class="container">

    <section class="mb-5">

            <div class="row">

                <div class="form-group col-12 col-md-8">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" id="descricao"  class="form-control" maxlength="50" value="" required autofocus>
                </div>

                <div class="form-group col-12 col-md-4">
                    <label for="statusRegistro" class="form-label">Status</label>
                    <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                        <option value="">.....</option>
                        <option value="1">Ativo</option>
                        <option value="2">Inativo</option>
                    </select>
                </div>

                <input type="hidden" name="action" value="">
                <input type="hidden" name="id" value="">

                <a href="<?= base_url() ?>/Departamento">Voltar</a>
                <button type="submit" value="submit" class="button button-login ml-3">Gravar</button>

            </div>

    </section>
    
</main>

