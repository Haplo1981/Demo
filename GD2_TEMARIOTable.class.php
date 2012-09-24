<?php

class GD2_TEMARIOTable extends Doctrine_Table
{

  /**
   * Cuenta el número de temas que tiene una Guía Docente en particular
   * @param <int> $idGuia Id de la guía docente
   * @param <int> $idGrupo Id del grupo de actividad
   * @param <mixed> $idPadre NULL para contar temas padre, el ID del tema padre
   * para contar sus hijos, 'all' para contar el total de temas.
   * @return <integer> Número de temas
   */
  public function cuentaTemas($idGuia, $idGrupo, $idPadre=null){
     $res = 0;
     if(is_null($idPadre)){
        //Cuenta padres
        $res = count($this->getTemasPadre($idGuia,$idGrupo));
     }else if($idPadre=='all'){
        $q = Doctrine_Core::getTable('GD2_TEMARIO')->createQuery()
                ->select('count(*) as n')
                ->where('id_guia = ?',$idGuia)
                ->andWhere('c.id_grupo = ?',$idGrupo)
                 ->fetchOne();
        $res = $q->n;
     }else{
         //Cuenta hijos
         $res = count($this->getTemasSecundarios($idPadre));
     }
     return $res;
  }

  /**
   * Devuelve el ID del primer elemento del temario, o del primer hijo si se 
   * especifica un elemento padre.
   * @param <int> $padre Id. del elemento del temario padre, NULL para buscar
   * el ID. del primer elemento del temario
   * @param <int> $idGuia Id de la Guia a buscar.
   * @param <int> $idGrupo Id del grupo de actividad.
   * @return <int> ID del primer elemento del temario, o del primer hijo.
   */
  public function getIdPrimerTema($padre,$idGuia, $idGrupo){
    
    if($padre != null){
        $query = $this->createQuery('c')
                ->select('c.id as id')
                ->where('c.padre = ?', $padre)
                ->andWhere('id_guia = ?',$idGuia)
                ->andWhere('c.id_grupo = ?',$idGrupo)
                ->andWhere('c.orden = 1');
    }else{
        $query = $this->createQuery('c')
                ->select('c.id as id')
                ->where('c.padre is null')
                ->andWhere('id_guia = ?',$idGuia)
                ->andWhere('c.id_grupo = ?',$idGrupo)
                ->andWhere('c.orden = 1');
    }
    $max = $query->fetchOne();

    return $max['id'];
  }

}
