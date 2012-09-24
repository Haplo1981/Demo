<?php use_helper('Date') ?>
<br/>
<table class="PortletHeaderColor" width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
      <tbody>
          <tr class="PortletHeaderColor">
              <td align="left" width="10" height="10">&nbsp;</td>
              <td class="PortletHeaderColor" width="100%" nowrap="">
                  <font class="PortletHeaderText" >10. PLANIFICACIÓN</font>
              </td>
              <td class="PorltetHeaderColor">&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </tbody>
</table>
<table class="RegionBorder" width="95%" align="center" cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td>
            <br/>

            <table width="90%" align="center" cellspacing="1" border="1"
                   style="border-color: rgb(153,0,0); border-collapse:collapse;">
                <tr>
                    <td align="center" valign="middle" height="40" colspan="5">
                        <a href="<?php echo url_for('planificacion/new');?>">
                            <img border="0" alt="Añadir" src="/images/bot-anadir.jpg" />
                        </a>
                    </td>
                </tr>
                <TR class="PortletText2" bgcolor="#cccccc">
                    <TD colspan="5" width="70%" align="center">
                        SECUENCIA DE TRABAJO, CALENDARIO, HITOS IMPORTANTES E INVERSIÓN TEMPORAL
                    </TD>
                </TR>
                <TR class="PortletText2" bgcolor="#cccccc">
                    <TD width="65%">Secuencia temática y de actividades (Actividades ordinarias y de evaluación)</TD>
                    <td width="10%">Periodos temporales aproximados</td>
                    <td width="15%">Fecha de inicio y fecha de fin</td>
                    <td width="5%">Inversión aproximada de tiempo de trabajo del estudiante</td>
                    <td width="5%">&nbsp;</td>
                </TR>
                <?php if(count($planificaciones)==0): ?>
                    <tr class="PortletText4">
                        <td align="Center" colspan="5">No se ha introducido ningún elemento.</td>
                    </tr>
                <?php else:?>
                    <?php foreach($planificaciones as $plan): ?>
                        <tr class="PortletText4">
                            <td><?php echo $sf_data->unescape(str_replace("script","****",$plan->getSecAct()));?></td>
                            <td><?php echo $plan->getPeriodoTemporal();?></td>
                            <td><?php echo $plan->getFechaIni()." - ".$plan->getFechaFin();?></td>
                            <td align="center">
                                <?php echo $plan->getTiempoStd();?>
                                <?php if($plan->getTiempoStd()):?>
                                    horas
                                <?php endif;?>
                            </td>
                            <td align="center" >
                            <?php echo link_to('<img border="0" alt="Editar" title="Editar"
                                         src="/images/editar.jpg" />',
                                        'planificacion/edit?id='.$plan->getId());?>
                                <?php echo link_to('<img border="0" alt="Borrar" title="Borrar"
                                     src="/images/borrar.jpg" />',
                                     'planificacion/delete?id='.$plan->getId(),
                                     array(
                                        'method' => 'delete',
                                        'confirm' => '¿Está seguro que desea eliminar esta entrada de la planificación de la guía docente?'));?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="3" class="PortletText2" align="right" bgcolor="#cccccc">
                            Tiempo de trabajo total invertido por el estudiante:
                        </td>
                        <td colspan="2" class="PortletText4">
                            <?php echo $total_horas;?> horas
                        </td>

                    </tr>
                <?php endif;?>
                <tr>
                    <td align="center" valign="middle" height="40" colspan="5">
                        <a href="<?php echo url_for('planificacion/new');?>">
                            <img border="0" alt="Añadir" src="/images/bot-anadir.jpg" />
                        </a>
                    </td>
                </tr>
            </table>
            <br/>
        </td>
    </tr>
</table>
