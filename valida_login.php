<?php
session_start();
require_once 'conexao.php';

$login = $_POST['nm_login'];
$senha = $_POST['ds_password'];

try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nm_login = :login AND ds_password = :senha");
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verifica se o usuário existe e a senha está correta

   // if(!empty($user['ds_password'])  && !empty($user['nm_login'])){	

        //if ($user && password_verify($senha, $user['ds_password'])) {
         if($user && $user['ds_password'] == $senha && $user['nm_login'] == $login){
            // Login válido - armazenar dados na sessão
            $_SESSION['id']          = $user['id'];
            $_SESSION['nm_nome']     = $user['nm_nome'];
            $_SESSION['nm_login']    = $user['nm_login'];
            $_SESSION['ds_email']    = $user['ds_email'];
            $_SESSION['ds_password'] = $user['ds_password'];
            $_SESSION['in_admin']    = $user['in_admin'];
            $_SESSION['logado']      = true;

            $_SESSION['foto_perfil'] = !empty($user['foto_perfil']) ? $user['foto_perfil'] : 'sem-foto.jpg';
            //  var_dump($_SESSION['foto_perfil']);
            if ($user['in_admin'] == 1) {
              $_SESSION['in_admin'] = true;
              echo json_encode([
                  'success' => true,
                  'redirect' => 'painel.php'
              ]);
          } else {
              echo json_encode([
                  'success' => true,
                  'redirect' => 'painel2.php'
              ]);
          }
          
      }
      else{
          echo json_encode(['success' => false, 'message' => 'Login ou senha incorretos.']);
      }
  
  } catch (PDOException $e) {
      echo "Erro ao acessar banco de dados: " . $e->getMessage();
  } catch (Exception $e) {
      echo "Erro inesperado: " . $e->getMessage();
  }
  
  
  ?>