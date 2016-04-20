<?php

use mvc\model\modelClass as model;
use mvc\config\configClass as config;

/**
* @description: En esta clase se manejara las consultas que tengar quever con la tabla  
* @author: 
 * Shirley Marcela Rivero <marce250494@hotmail.com>
 * Kelly Andrea Manzano <kellinandrea18@hotmail.com>
 * Diana Marcela Hormiga<dianamarce0294@hotmail.com>
* @category: Pertenece al modelo  es la Table .
*/
class localidadTableClass extends localidadBaseTableClass {
  
      public static function getNombreById($id) {
      try {
          $sql = 'SELECT nombre AS nombre ' .
                    'FROM ' . localidadTableClass::getNameTable() .
                    ' WHERE  ' . localidadTableClass::ID . ' = :id';

            $params = array(
                ':id' => $id
            );

            $answer = model::getInstance()->prepare($sql);
            $answer->execute($params);
            $answer = $answer->fetchAll(PDO::FETCH_OBJ);
            return $answer[0]->nombre;
      } //end try
      catch (PDOException $exc) {
          throw $exc;
      }//end cath
    }
    
      public static function getTotalpages($lines, $where) {
        try {
            $sql = 'SELECT count (' . localidadTableClass::ID . ') AS cantidad ' .
                    'FROM ' . localidadTableClass::getNameTable(). ' ' .
                    ' WHERE '. localidadTableClass::DELETED_AT . ' IS NULL ';
     
             if (is_array($where) === true) {
                foreach ($where as $fields => $value) {
                    if (is_array($value)) {
                        $sql = $sql . '  AND  ' . $fields . '  BETWEEN  ' . ((is_numeric($value[0])) ? $value[0] : " '$value[0]' ") . 'AND' . ((is_numeric($value[1])) ? $value[1] : " '$value[1]' ");
                    }//end if 
                    else {
                        $sql = $sql . '  AND   ' . $fields . '  =  ' . ((is_numeric($value)) ? $value : " '$value' ");
                    }//end else
                }//end foreach
            }//end  if

            $answer = model::getInstance()->prepare($sql);
            $answer->execute();
            $answer = $answer->fetchAll(PDO::FETCH_OBJ);
            return ceil($answer[0]->cantidad / $lines);
        }//end try
        catch (PDOException $exc) {
            throw $exc;
        }//end catch
    }//end
    
     public static function getLocalidadProfile($id) {
    try {
        
        /*
         *select localidad.nombre from usuario,  localidad, dato_usuario where 
         * dato_usuario.localidad_id=localidad.id 
         *  
         * and dato_usuario.usuario_id=usuario.id and usuario.id='82'
         */
        
      $sql = 'SELECT ' .localidadTableClass::NOMBRE.
              ' FROM '.usuarioTableClass::getNameTable().' , '. localidadTableClass::getNameTable().' , '. datoUsuarioTableClass::getNameTable().
              ' WHERE '.datoUsuarioTableClass::LOCALIDAD_ID.' = '. localidadTableClass::ID.
              'AND' .
              ' AND '. usuarioTableClass::getNameTable().'.'.usuarioTableClass::ID.' = '.$id;
      
  //echo $sql;
     // exit();
       
       return model::getInstance()->query($sql)->fetchAll(\PDO::FETCH_OBJ);
    } catch (PDOException $exc) {
      throw $exc;
    }
  }
        } //end class



