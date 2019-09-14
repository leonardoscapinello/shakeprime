<div class="row">
    <div class="offset-2"></div>
    <div class="col col-8">
        <h2>{{title}}</h2>
        <h3>Preencha o formulário de cadastro abaixo para criação de um novo agente de bot. Com um novo agente, você
            pode definir diferentes intenções, ações e iteratividade para atender diversos setores dentro da sua
            corporação.</h3>
        <div class="content-box">
            <div class="form-input">
                <label for="botname"><i class="far fa-robot"></i>Nome do Personagem de Bot</label>
                <input type="email" name="botname" id="botname" placeholder="Digite o nome do personagem de bot"
                       value="<?php echo get_request("botname"); ?>" required/>
            </div>

            <div class="form-input" align="center">
                <button>Criar novo bot</button>
            </div>
        </div>
    </div>
    <div class="offset-2"></div>
</div>