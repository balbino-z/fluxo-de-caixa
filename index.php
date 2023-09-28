<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Fluxo de Caixa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/trabalho/style.css">
</head>
<body>
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>
<div class="section">
  <div class="container">
    <div class="row full-height justify-content-center">
      <div class="col-12 text-center align-self-center py-5">
        <div class="section pb-5 pt-5 pt-sm-2 text-center">
          <h6 class="mb-0 pb-3"><span>Login </span><span>Cadastrar</span></h6>
          <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
          <label for="reg-log"></label>
          <div class="card-3d-wrap mx-auto">
            <div class="card-3d-wrapper">
              <div class="card-front">
                <div class="center-wrap">
                  <div class="section text-center">
                    <h4 class="mb-4 pb-3">Login</h4>
                    <form action="processar_login.php" method="POST">
                      <div class="form-group">
                          <input type="text" class="form-style" name="username_login" placeholder="Nome de Usuário">
                          <i class="input-icon uil uil-user"></i>
                      </div>	
                      <div class="form-group mt-2">
                          <input type="password" class="form-style" name="password_login" placeholder="Senha">
                          <i class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <button type="submit" class="btn mt-4">Login</button>
                  </form>                  
                    <p class="mb-0 mt-4 text-center"><a href="esqueceu_senha.php" class="link">Esqueceu sua senha?</a></p>
                  </div>
                </div>
              </div>
              <div class="card-back">
                <div class="center-wrap">
                  <div class="section text-center">
                    <h4 class="mb-3 pb-3">Cadastrar</h4>
                    <form action="processar_registro.php" method="POST">
                      <div class="form-group">
                        <input type="text" class="form-style" name="nome_completo" placeholder="Nome Completo">
                        <i class="input-icon uil uil-user"></i>
                      </div>	
                      <div class="form-group mt-2">
                        <input type="tel" class="form-style" name="telefone" placeholder="Telefone">
                        <i class="input-icon uil uil-phone"></i>
                      </div>	
                      <div class="form-group mt-2">
                        <input type="text" class="form-style" name="username_registro" placeholder="Nome de Usuário">
                        <i class="input-icon uil uil-user"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" class="form-style" name="password_reg" placeholder="Senha">
                        <i class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <div class="form-group mt-2">
                      <label for="tipo_conta">Tipo de Conta:</label>
                      <select class="form-control" name="tipo_conta">
                      <option value="1">Usuário</option>
                      <option value="2">Administrador</option>
                      </select>
                      </div>
                      <button type="submit" class="btn mt-4">Registrar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
