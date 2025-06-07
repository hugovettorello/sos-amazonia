<?php

    include 'Voluntarios.php' ;
    
    class Voluntariosservice 
    {
        //ações / metódos 
               
        //post - Incluir
        public function post()
        {   
            //Pegar os dados em formato JSON para incluir no BD.
            $dados = json_decode(file_get_contents('php://input'), true, 512);
            if ($dados == null){
                  throw new Exception("Falta os dados para incluir !");
            }
            return Voluntarios::insert($dados);              
        }

        //get - Buscar
        public function get(  $id  = null  ) 
        {
            if( $id ) {
                //Buscar o aluno pelo Id / Código
                return Voluntarios::select($id);    
            } else {
                //Buscar todos os aluno da tabela
                return Voluntarios::selectAll();    
            }
        }

        //put - Alterar
        public function put(  $id  = null  ) {
            if ( $id == null  )
            {
                throw new Exception("Falta o código!") ;
            }

            //Pegar os dados em formato JSON para alterar no BD.
            $dados = json_decode(file_get_contents('php://input'), true, 512);
            if ( $dados == null  )
            {
                throw new Exception("Falta as informações!") ;
            }

             //Alterar os dados do aluno da tabela
             return Voluntarios::update( $id , $dados );   
        }


        //delete - Deletar
        public function delete( $id = null ) {
            if ( $id == null  )
            {
                throw new Exception("Falta o código!") ;
            }

            //Excluir os dados do aluno na tabela
            return Voluntarios::delete( $id );   
        }

    }



?>