<?php

use mvc\model\modelClass as model;
use mvc\config\configClass as config;

/**
  /**
 * @description: En esta clase se manejara las consultas que tengar quever con la tabla
 * @author:
 * Shirley Marcela Rivero <marce250494@hotmail.com>
 * Kelly Andrea Manzano <kellinandrea18@hotmail.com>
 * Diana Marcela Hormiga<dianamarce0294@hotmail.com>
 * @category: Pertenece al modelo  es la Table .
 */
class datoUsuarioTableClass extends datoUsuarioBaseTableClass {

  /**
   * @author:
   * Shirley Marcela Rivero <marce250494@hotmail.com>
   * Kelly Andrea Manzano <kellinandrea18@hotmail.com>
   * Diana Marcela Hormiga<dianamarce0294@hotmail.com>
   * @return datatype description: Array $usuario, $password, $apellido, $correo, $genero, $fechaNacimiento, $localidad, $tipoDocumento, $organizacion.
   */
  public static function getNombreById($id) {
    try {
      $sql = 'SELECT nombre AS nombre ' .
              'FROM ' . datoUsuarioTableClass::getNameTable() .
              ' WHERE  ' . datoUsuarioTableClass::ID . ' = :id';

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
      $sql = 'SELECT count (' . datoUsuarioTableClass::ID . ') AS cantidad ' .
              'FROM ' . datoUsuarioTableClass::getNameTable() . ' ' .
              ' WHERE ' . datoUsuarioTableClass::DELETED_AT . ' IS NULL ';

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
  }
  

//end function

  public static function getIdUsuarioByIdDatoUsuario($id) {
    try {
      $sql = 'SELECT usuario.id '
              . 'FROM usuario '
              . 'JOIN dato_usuario ON usuario.id = dato_usuario.usuario_id '
              . 'WHERE dato_usuario.id = :id';
      $params = array(
          ':id' => $id
      );

      $answer = model::getInstance()->prepare($sql);
      $answer->execute($params);
      $answer = $answer->fetchAll(PDO::FETCH_OBJ);
      return $answer[0]->id;
    }//end try
    catch (PDOException $exc) {
      throw $exc;
    }//end catch
  }

   public static function getAdminContactenos() {
    try {


   $sql = 'SELECT nombre, apellido, correo  '
              . 'FROM dato_usuario, usuario '
              . 'WHERE usuario.id=dato_usuario.usuario_id'
              . ' AND usuario.id=1';


      return model::getInstance()->query($sql)->fetchAll(\PDO::FETCH_OBJ);
    } catch (PDOException $exc) {
      throw $exc;
    }
  }
  
  public static function getGenero($id) {
    try {
      $sql = 'SELECT genero AS genero ' .
              'FROM ' . datoUsuarioTableClass::getNameTable() .
              ' WHERE  ' . datoUsuarioTableClass::ID . ' = :id';

      $params = array(
          ':id' => $id
      );

      $answer = model::getInstance()->prepare($sql);
      $answer->execute($params);
      $answer = $answer->fetchAll(PDO::FETCH_OBJ);
      return $answer[0]->genero;
    } //end try
    catch (PDOException $exc) {
      throw $exc;
    }//end cath
  }

  
  
}

//end class
