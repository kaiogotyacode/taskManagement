<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../taskManagement/assets/css/style.css">
</head>

<body>
    <div class="container">
        <div class="loginContainer">

            <h1 class="display-2 loginTitulo">REGISTER</h1>

            <form>

                <div class="row mt-3">    
                    <div class="col-12">                    
                        <label for="email">Nome Completo: </label>
                    </div>
                    <div class="col-12">
                        <input type="text" id="Nome" class="form-control">
                    </div>
                </div>

                <div class="row mt-3"> 
                    <div class="col-12">
                        <label for="email">Email: </label>
                    </div>
                    <div class="col-12">
                        <input type="text" id="email" class="form-control">
                    </div>
                </div>

                <div class="row mt-3">  
                    <div class="col-12">
                        <label for="email">Senha: </label>
                    </div>
                    <div class="col-12">
                        <input type="password" id="senha" class="form-control">
                    </div>
                </div>
             
                <div class="row mt-3">  
                    <div class="col-12">
                        <label for="email">Confirmar Senha: </label>
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