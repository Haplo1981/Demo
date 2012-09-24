<?php

/**
 * planificacion actions.
 *
 * @package    GuiasDocentes2.0
 * @subpackage planificacion
 */
class planificacionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $this->getUser()->setAttribute('pasoActual', '9');
    //recogemos el id de la guía que estamos modificando de la sesión
    // si no existe o la sesión ha expirado redirigimos a la página de
    //inicio

    $idGuia = $this->getUser()->getAttribute('guiaId');
    $idGrupo = $this->getUser()->getAttribute('idGrupo');
    $this->idGuia=$idGuia;
    $this->idGrupo=$idGrupo;
    if(null === $idGuia || null === $idGrupo){
      $this->redirect('homepage');
    }
    $idTema =$request->getParameter('tema');
    $this->tema = $idTema;

    //Si no se ha introducido el tema se va al primero
    if(!$this->tema){
      $this->tema = Doctrine_Core::getTable('GD2_TEMARIO')->getIdPrimerTema(null,$idGrupo);
    }
    //comprobamos que el tema que estamos editando pertenece a la guia docente
    //actual
    $obTema = Doctrine_Core::getTable('GD2_TEMARIO')->find(array($idTema));
    if($idGuia != $obTema->getIdGuia()){
        $this->redirect('homepage');
    }
    $this->redirect('planificacion/tema/'.$this->tema);
    $this->totalTemas = Doctrine::getTable('GD2_TEMARIO')->cuentaTemas($idGuia, $idGrupo, null);
  }

  public function executeNew(sfWebRequest $request)
  {
    $idGuia = $this->getUser()->getAttribute('guiaId');
    $idGrupo = $this->getUser()->getAttribute('idGrupo');
    if(null === $idGuia || null === $idGrupo){
      $this->redirect('homepage');
    }
    $planificacion = new GD2_PLANIFICACION();
    $planificacion->setIdGuia($idGuia);
    $planificacion->setIdGrupo($idGrupo);
    //Si estamos creando la planificacion por primera vez, metemos el tema 1
    $planificacion->setTema(Doctrine::getTable('GD2_TEMARIO')
            ->getIdPrimerTema(null, $idGuia, $idGrupo));
    $this->actividades = Doctrine::getTable('GD2_ACTIVIDADES')->findByGuiaGrupo($idGuia, $idGrupo);
    $this->temaStr = $planificacion->getTemaString();
    $this->form = new GD2_PLANIFICACIONForm($planificacion);
  }

  public function executeCreate(sfWebRequest $request){
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $this->form = new GD2_PLANIFICACIONForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');

  }

  public function executeDelete(sfWebRequest $request){
      $request->checkCSRFProtection();
      $this->forward404Unless($comp = Doctrine::getTable('GD2_PLANIFICACION')->find(array($request->getParameter('id'))), sprintf('La entrada de planificación (%s) no existe.', $request->getParameter('id')));
      $comp->delete();
      $this->redirect('planificacion');
  }

  protected function processForm(sfWebRequest $request, sfForm $form){
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
        
      $guia = $form->save();
      $p = $request->getPostParameters();
      $temaSig = $p['gd2_planificacion']['siguienteTema'];
      $this->redirect('planificacion/edit?tema='.$temaSig);
    }
  }

}
