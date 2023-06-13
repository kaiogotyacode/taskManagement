<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../taskManagement/assets/css/style.css">
    <script src="../taskManagement/assets/js/script.js"></script>
</head>

<body>
    <div class="container">
        <div class="signUpContainer">

            <h1 class="display-2 loginTitulo">REGISTER</h1>

            <form action="../taskManagement/login/metCadastro.php" method="POST" onsubmit="return validarCadastro()">

                <div class="row mt-3">    
                    <div class="col-12">                    
                        <label for="nome">Nome Completo: </label>
                    </div>
                    <div class="col-12">
                        <input type="text" name="nome" id="nome" class="form-control">
                    </div>
                </div>

                <div class="row mt-3"> 
                    <div class="col-12">
                        <label for="email">Email: </label>
                    </div>
                    <div class="col-12">
                        <input type="text" name="email" id="email" class="form-control">
                    </div>
                </div>

                <div class="row mt-3">  
                    <div class="col-12">
                        <label for="senha">Senha: </label>
                    </div>
                    <div class="col-12">
                        <input type="password" name="senha" id="senha" class="form-control">
                    </div>
                </div>
             
                <div class="row mt-3">  
                    <div class="col-12">
                        <label for="confirmarSenha">Confirmar Senha: </label>
                    </div>
                    <div class="col-12">
                        <input type="password" id="confirmarSenha" class="form-control">
                    </div>
                </div>
           
    
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <input type="submit"  class="btn btn-secondary mt-2" value="Cadastrar">
                    </div>
                </div>     
                
              
                    <div class="col-12 goToLogin">
                        <a class="text-left signUp" href="../taskManagement/index.php" >Já possui uma conta? Ir para login </a>
                    </div>
         

            </form>

        </div>
    </div>
</body>

</html>