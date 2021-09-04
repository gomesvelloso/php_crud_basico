<?php
/*
* Classe responável pela conexão com o banco de dados. 
* @since 2021-08-01
* @author Dennis Henrique
*/
class conexao
{
    protected $host  = 'localhost';
    protected $bd    = 'empresa';
    protected $pass  = 'q1w2e3';
    protected $user  = 'root';

    public function getConexao(){

        $conn = mysqli_connect($this->host, $this->user, $this->pass, $this->bd);
        if($conn){
            return $conn;
        }else{
            echo "Erro ao conectar o banco de dados";exit;
        }
    }
}
?>