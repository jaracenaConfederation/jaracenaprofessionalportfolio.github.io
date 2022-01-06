<?php 
        
function generar_xls_compras($obtener_cheques,$idProyecto,$nombreProyecto,$centro_costo,$ano,$mes)
{
                $suma_boletas  = 0;
                $suma_facturas = 0;
                $nombre_archivo = 'Reporte_Pagos_Proyecto_'.$idProyecto.'_'.$mes.'-'.$ano.'.xls';
                $linea_titulos = 0;
                
                $reporte_compras                                        = $_SESSION['tmp']["reporte_compras"];
                $reporte_compras_solicitudes_anuladas                   = $_SESSION['tmp']["reporte_compras_solicitudes_anuladas"];
                $ordenes_complementarias                                = $_SESSION['tmp']["ordenes_complementarias"];
                $obtener_cheques                                        = $_SESSION['tmp']["obtener_cheques"];
                $obtener_facturas_por_periodo                           = $_SESSION['tmp']["obtener_facturas_por_periodo"] ;
                $obtener_facturas_sueltas                               = $_SESSION['tmp']["obtener_facturas_sueltas"];
                $obtener_cheques_facturas_sueltas                       = $_SESSION['tmp']["obtener_cheques_facturas_sueltas"];
                $idProyecto                                             = $_SESSION['tmp']["idProyecto"];
                $nombreProyecto                                         = $_SESSION['tmp']["nombreProyecto"];
                $centro_costo                                           = $_SESSION['tmp']["centro_costo"];
                $movimientos_solicitudes_compras                        = $_SESSION['tmp']["movimientos_solicitudes_compras"]; 
                $octooc                                                 = $_SESSION['tmp']["octooc"];
                $factofac                                               = $_SESSION['tmp']["factofac"];
                $scAoc                                                  = $_SESSION['tmp']["scAoc"];
                $obtener_cheques                                        = $_SESSION['tmp']["obtener_cheques"] ;
                $anulaciones_solicitudes_compras                        = $_SESSION['tmp']["anulaciones_solicitudes_compras"]; 
                $anulaciones_ordenes_compras                            = $_SESSION['tmp']["anulaciones_ordenes_compras"]; 
                $notas_credito                                          = $_SESSION['tmp']["notas_credito"];
                $mes                                                    = $_SESSION['tmp']["mes_seleccion"];
                $ano                                                    = $_SESSION['tmp']["ano_seleccion"];
                $obtener_solicitudes_compras                            = $_SESSION['tmp']['obtener_solicitudes_compras'];  //09-01-2019
                $obtener_ordenes_compras                                = $_SESSION['tmp']['obtener_ordenes_compras']; //09-01-2019 /24
                
                array($lista_ordenes_complementaria);
                foreach ($ordenes_complementarias as $orden_complementaria)
                {
                    $lista_ordenes_complementarias[$orden_complementaria['ORDEN']]["ORDEN"]  = $orden_complementaria['ORDEN_REFERENCIA'];
                    $lista_ordenes_complementarias[$orden_complementaria['ORDEN']]["FECHA"]  = $orden_complementaria['FECHA'];
                    $lista_ordenes_complementarias[$orden_complementaria['ORDEN']]["ESTADO"] = $orden_complementaria['ESTADO'];
                    $lista_ordenes_complementarias[$orden_complementaria['ORDEN']]["TOTAL"]  = $orden_complementaria['TOTAL'];
                }
                array($lista_facturas_por_periodo);
                foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                {
                    $lista_facturas_por_periodo[$facturas_por_periodo['ORDEN']][0] = $facturas_por_periodo['DOCUMENTO'];
                    $lista_facturas_por_periodo[$facturas_por_periodo['ORDEN']][1] = $facturas_por_periodo['CODIGO_PRV'];
                }
                // Se marcan las OC que estan anuladas en el sistema
                array($doc_procesado);
                foreach ($anulaciones_ordenes_compras as $key => $data) //Se recorre el array que indica que los valores de solicitudes son con valores negativos
                {
                    //Se pregunta si en el estado de la solicitud indica si es una anulación
                    $encontrado = mb_stristr($data[0]["estado"],"anulacion");
                    if ($encontrado)
                    {
                        $doc_procesado[$key] = 1;
                    }
                }

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"".$nombre_archivo."\";");
		header('Pragma: private'); // allow private caching
		echo'<meta http-equiv="Content-type" content="text/html;charset=iso8859-1" /> ';
                
                echo '<table border =1>';
		echo    '<thead>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'CENTRO DE COSTO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $centro_costo ;
		echo            '</th>';
		echo        '</tr>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'ITEM PRESUPUESTARIO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $idProyecto ;
		echo            '</th>';
		echo        '</tr>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'PROYECTO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $nombreProyecto;
		echo            '</th>';
		echo        '</tr>';
		echo    '</thead>';
		echo '</table>';
                           
		echo '<br>';
	
 ?>

<div class="table-responsive">
    <table id="tabla_contenedora_reporte_compras" class="table table-bordered table-striped " border =1>
        <thead>
            <tr>
                <th style="background-color:#eeeeee;">Solicitudes de compra</th>
                <th                                  >Ordenes de compra</th>
                <th style="background-color:#eeeeee;">Facturas</th>
                <th                                  >Formas de pago</th>
            </tr>
        </thead>
        <tbody  class="table table-striped table-bordered">
            <?php
                $contador=0;
                array($indiceSctoOC);
                array($ordenes_enlazadas_a_solicitud);
 
                foreach ($reporte_compras as $rc)
                {
                    //Se analiza si la SC esta anulada para indicar que se debe saltar
                    $solicitud_anulada_respuesta = 0;
                    foreach ($anulaciones_solicitudes_compras as $key =>$solicitud_anulada) 
                    {
                        if ($key == $rc['NO_DOCUMENTO'])
                        {
                            $solicitud_anulada_respuesta = 1;
                        }
                    }

                    $existe_factura_relacionada = 0;
                    $factura_suelta = 0;
                    //Si se estan procesando las OC restatantes de la lista se debe consultar sai tambien tienen facturas asociadas
                    if ($rc['TIPO_DOC'] == 'OC')
                    {
                        foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                        {
                                if($facturas_por_periodo['ORDEN'] == $rc['NO_DOCUMENTO'])
                                {
                                    $existe_factura_relacionada = 1;
                                }
                        }
                    }
                    
                    if ($rc['TIPO_DOC'] == 'FA')
                    {
                        foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                        {
                                if(($facturas_por_periodo['DOCUMENTO'] == $rc['NO_DOCUMENTO']) && ($facturas_por_periodo['MONTO'] == $rc['MONTO'])) // Pertenece al devengado
                                {
                                    $existe_factura_relacionada = 1;
                                }
                                else
                                {
                                    $factura_suelta = 1;
                                }
                        }
                    }
                    
                    
                //Si el documento no ha sido procesado se permite que se analice y se procese. además si es una SC, OC o FA tambien se permite
                if ( ( $solicitud_anulada_respuesta != 1) && ($doc_procesado[$rc['NO_DOCUMENTO']] == null) && ( ($rc['TIPO_DOC'] =='SC') || ($rc['TIPO_DOC'] =='OC') || ($rc['TIPO_DOC'] == 'FA' && $existe_factura_relacionada == 1) || ($rc['TIPO_DOC'] == 'FA' && $factura_suelta == 1)) )
                {        
                    $doc_procesado[$rc['NO_DOCUMENTO']] = 1;//Array que identifica a las facturas, ordenes y las solicitudes de compra que ya han sido procesadas para que más adelante no las repita 
                    $contador++;
                    
                    $existencia_factura_suelta = 0;
                
                    foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                    {
                        if(($facturas_por_periodo['DOCUMENTO'] == $rc['NO_DOCUMENTO']) && !mb_stristr($rc['ESTADO'],'F-IRR'))
                        {
                             $existencia_factura_suelta = 1;
                        }
                    }
                    
                    foreach ($obtener_facturas_sueltas as $fac_suelta)
                    {
                        if ($fac_suelta['NO_DOCUMENTO'] == $rc['NO_DOCUMENTO'])
                        {
                            $existencia_factura_suelta = 1;
                        }
                    }    
                    if (( ($rc['TIPO_DOC'] =='SC') || ($rc['TIPO_DOC'] =='OC') || ($rc['TIPO_DOC'] == 'FA' && ($existe_factura_relacionada == 1 || $existencia_factura_suelta == 1))))
                    {      
            ?>
            <tr border = 3>
            <td style="background-color:#eeeeee;" ><!--Casilla de la solicitud de compra-->

                         <?php 
                            //Se suman los montos positivos de los documentos relacionados.                                                 
                            $suma_monto = 0;     
                            foreach ($movimientos_solicitudes_compras[$rc['NO_DOCUMENTO']] as $rows)
                            {
                                if ($rows['monto'] >= 0){
                                    $suma_monto = $suma_monto + $rows['monto'];
                                }
                                if($rc['NO_DOCUMENTO'] != $rc['DOCUMENTO_REF']){
                                    array_push($indiceSctoOC, $rc['documento_ref']);
                                } 
                            } 

                            if ($rc['TIPO_DOC'] == 'SC')
                            { 
                            ?> 
                
                            <?php 
                                if ($linea_titulos == 1)
                                {  
                            ?>
                                  <!--  <strong>Solicitud de Compra:</strong> -->
                           <?php
                                }
                           ?>

                            <div class="form-group">
                              <div class=" table-resposive">
                                    <table class="table table-striped table-bordered">
                                       
                                            <?php 
                                                if ($linea_titulos == 1)
                                                { 
                                            ?> 
                                        <thead>
                                            <tr >
                                                <th style="border: 1">N°Solicitud</th>
                                                <th nowrap style="border: 1">Fecha creación</th>
                                                <th style="border: 1">Tipo solicitud</th>
                                                <th style="border: 1">Estado</th>
                                                <th>Monto</th>
                                            </tr>
                                            
                                        </thead>
                                           <?php
                                                }
                                           ?>
                                        <tbody>
                                            <tr
                                                <?php 
                                                    if ($obtener_solicitudes_compras[$rc['NO_DOCUMENTO']]['ESTADO']!= 'O' ){
                                                        echo 'class="bg-warning text-dark"';
                                                    }
                                                ?>
                                            >
                                                <td>
                                                    <?php 
                                                        if($rc['TIPO_DOC'] == 'SC')
                                                        {
                                                            echo $rc['NO_DOCUMENTO'];
                                                        }
                                                     ?>
                                                </td>
                                                <td >
                                                    <?php if($rc['TIPO_DOC'] == 'SC')
                                                          {
                                                            echo (date( "d-m-Y", strtotime( ( $rc['FECHA'] ) ) ));
                                                          }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if($rc['TIPO_DOC'] == 'SC')
                                                          {
                                                            if ($obtener_solicitudes_compras[$rc['NO_DOCUMENTO']]['TIPO_SOLICITUD'] == 'C'){
                                                                echo 'BIENES';
                                                            }elseif ($obtener_solicitudes_compras[$rc['NO_DOCUMENTO']]['TIPO_SOLICITUD'] == 'S'){
                                                                echo 'SERVICIOS';
                                                            }
                                                          }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php   if($rc['TIPO_DOC'] == 'SC')
                                                            {
                                                                switch ($obtener_solicitudes_compras[$rc['NO_DOCUMENTO']]['ESTADO'])
                                                                {
                                                                    case 'O':
                                                                        echo 'ORDEN DE COMPRA';
                                                                        break;
                                                                    case 'A':
                                                                        echo 'APROBADA';
                                                                        break;
                                                                     case 'C':
                                                                        echo 'CERRADA';
                                                                        break;
                                                                     case 'R':
                                                                        echo 'RECHAZADA';
                                                                        break;
                                                                     case 'P':
                                                                        echo 'PENDIENTE';
                                                                        break;
                                                                }
                                                            }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if($rc['TIPO_DOC'] == 'SC')
                                                          {
                                                            echo obtener_precio($suma_monto);
                                                          }
                                                    ?>
                                                </td>

                                            </tr>
    <!-- ************************************************************************************************************** -->                                        
                                            
          <?php if($rc['TIPO_DOC'] == 'SC')
                {
                    $existe_relacion = 0;
                    foreach ($scAoc[$rc['NO_DOCUMENTO']] as $val)
                    {
                        if ($val =! null){
                            $existe_relacion= 1;
                        }
                    }

                    if ( $existe_relacion == 1 )
                    {
                                $hay_complemento = 0;
                                foreach ($scAoc[$rc['NO_DOCUMENTO']] as $val_scAoc)
                                {
                                    foreach($lista_ordenes_complementarias as $key =>$lo)
                                    {
                                        if($lo['ORDEN'] == $val_scAoc)
                                        {
                                            $hay_complemento = 1;
                                        }
                                    }
                                }
                                if ($hay_complemento == 1)
                                {
                                        foreach ($scAoc[$rc['NO_DOCUMENTO']] as $val_scAoc)
                                        {
                                            $hay_complemento_relacionado = 'no';
                                            foreach($lista_ordenes_complementarias as $key => $lo)
                                            {
                                                if($lo['ORDEN'] == $val_scAoc)
                                                {
                                                    if ($lo['ORDEN'])
                                                    {
                                                        $hay_complemento_relacionado = 'si';
                                                    }
                                                }
                                            }
                                            if ($hay_complemento_relacionado == 'si')
                                            {
                                                unset($lista_de_lineas_a_imprimir);
                                                
                                                foreach($lista_ordenes_complementarias as $key => $lo)
                                                {
                                                    if($lo['ORDEN'] == $val_scAoc)
                                                    {
                                                        $doc_procesado[$key] = 1;//Array que identifica a las ordenes de compra que ya an sido procesadas para que mas adelante no las repita

                                                        $lista_de_lineas_a_imprimir[]= $lo['FECHA'];
                                                    }
                                                }
                                                foreach ($lista_de_lineas_a_imprimir as $indice => $fecha)
                                                {
                                                    echo ("<tr>");
                                                        echo ("<td>");
                                                            echo $rc['NO_DOCUMENTO'];
                                                        echo ("</td>");
                                                        
                                                        echo ("<td>");
                                                        echo ("</td>");
                                                        
                                                        echo ("<td>");
                                                        echo ("</td>");
                                                        
                                                        echo ("<td>");
                                                        echo ("</td>");
                                                        
                                                        echo ("<td>");
                                                            echo 0;
                                                        echo ("</td>");
                                                    echo ("</tr>");       
                                                }        
                                            }
                                        }
                                        
                                    }
                        }
                }
                ?>                                      
     <!-- **********************************************************************************************************************-->                                       
                                        </tbody>   
                                    </table>
                                </div>
                            </div>
                <?php 

                    }
                    else
                    {
                        if (($rc['TIPO_DOC'] =='FA') || ($rc['TIPO_DOC'] =='OC'))
                        {
                            if ($linea_titulos == 1){
                                 echo '<strong>Solicitud de Compra:</strong><br>';
                            }
                         ?>   
                            <table>
                                <tbody>
                                    <tr>
                                        <td>S/SC</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>      
                     <?php       
                            //echo 'S/SC';
                        }
                    }

                    ?>

            </td> <!--Casilla de la solicitud de compra-->
     

            <td><!--Casilla de la orden de compra-->

                <?php if($rc['TIPO_DOC'] == 'SC')
                {
                    $existe_relacion = 0;
                    foreach ($scAoc[$rc['NO_DOCUMENTO']] as $val)
                    {
                        if ($val =! null){
                            $existe_relacion= 1;
                        }
                    }

                    if ( $existe_relacion == 1 )
                    {
                        ?>
                                <div class="form-inline">
                                    <div class=" table-resposive">
                                        <table class="table table-striped ">
                                        <?php
                                            if ($linea_titulos == 1)
                                            {        
                                        ?>
                                            <thead>
                                                <tr>
                                                    <th>N° OC</th>
                                                    <th nowrap>Fecha creación</th>
                                                    <th>Estado</th>
                                                    <th>Monto</th>
                                                    <!--<th>Monto</th>-->
                                                </tr>
                                            </thead>
                                        <?php
                                            }      
                                        ?>    
                                            
                                            <tbody>    

                                                <?php
                                                    array($oc_enlace_factura); //En este array se almacenan los numeros de OC que se van a enlazar con las facturas
                                                    $oc_enlace_factura = null;

                                                    foreach ($scAoc[$rc['NO_DOCUMENTO']] as $val)
                                                    {
                                                        $doc_procesado[$val] = 1; //Array que identifica a las ordenes de compra que ya an sido procesadas para que más adelante no las repita
                                                        $oc_enlace_factura[$val]='xxx';
//                                                         debug($existe_factura_relacionada);
                                                        
                                                        if ($obtener_ordenes_compras[$val]['ESTADO']!= 'F')
                                                        {
                                                            $clase = 'bg-warning';
                                                        }    
                                                        else
                                                        {
                                                            $clase='';
                                                        }
                                                ?>
                                                <tr class = "<?php echo $clase ?>">
                                                    <td>
                                                        <?php echo $val ?>
                                                    </td>
                                                    <td>
                                                         <?php echo date( "d-m-Y", strtotime(($obtener_ordenes_compras[$val]['FECHA'])))?>
                                                     </td>
                                                    <td>
                                                        <?php 
                                                            switch ($obtener_ordenes_compras[$val]['ESTADO'])
                                                            {
                                                                case 'P':
                                                                    echo 'PENDIENTE';
                                                                    break;
                                                                case 'E':
                                                                    echo 'FIRMADA';
                                                                    break;
                                                                 case 'F':
                                                                    echo 'EMITIDA';
                                                                    break;
                                                                 case 'A':
                                                                    echo 'ANULADA';
                                                                    break;
                                                            }
                                                        ?>                                                                                               
                                                    </td>
                                                    <td>
                                                        <?php echo obtener_precio($obtener_ordenes_compras[$val]['TOTAL'])?>
                                                    </td>
                                                </tr>
                                                
                                                
                                                <?php    
                                                 //Rutina que completa las lineas vacias del reglon con el numero de documento y monto cero   
                                                 /*       foreach ($lista_de_lineas_a_imprimir as $indice => $fecha)
                                                        {
                                                            echo ("<tr>");
                                                                echo ("<td>");
                                                                    echo $rc['NO_DOCUMENTO'];
                                                                echo ("</td>");

                                                                echo ("<td>");
                                                                echo ("</td>");

                                                                echo ("<td>");
                                                                echo ("</td>");

                                                                echo ("<td>");
                                                                    echo 0;
                                                                echo ("</td>");
                                                            echo ("</tr>");       
                                                        }   */
                                                    } 
                                                ?>
                                            </tbody>   
                                        </table>
                                    </div>
                                </div>

                            <?php 

                                $hay_complemento = 0;
                                foreach ($scAoc[$rc['NO_DOCUMENTO']] as $val_scAoc)
                                {
                                    foreach($lista_ordenes_complementarias as $key =>$lo)
                                    {
                                        if($lo['ORDEN'] == $val_scAoc)
                                        {
                                            $hay_complemento = 1;
                                        }
                                    }
                                }
                                    if ($hay_complemento == 1)
                                    {
                            ?>
                                <div class="form-inline">
                                <table >

                                    <tbody>
                                <?php
                                    foreach ($scAoc[$rc['NO_DOCUMENTO']] as $val_scAoc)
                                    {
                                        $hay_complemento_relacionado = 'no';
                                        foreach($lista_ordenes_complementarias as $key => $lo)
                                        {
                                            if($lo['ORDEN'] == $val_scAoc)
                                            {
                                                if ($lo['ORDEN'])
                                                {
                                                    $hay_complemento_relacionado = 'si';
                                                }
                                            }
                                        }
                                        if ($hay_complemento_relacionado == 'si')
                                        {
                                ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                    foreach($lista_ordenes_complementarias as $key => $lo)
                                                    {
                                                        if($lo['ORDEN'] == $val_scAoc)
                                                        {
                                                            $doc_procesado[$key] = 1;//Array que identifica a las ordenes de compra que ya an sido procesadas para que mas adelante no las repita

                                                            $lista_fecha[]= $lo['FECHA'];
                                                            $lista_estado [] =  $lo['ESTADO']; 
                                                            $lista_total [] =  $lo['TOTAL'];
                                                    ?>
                                                        C_<?php echo $key.'<br>' ;
                                                    
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                
                                                <td nowrap>
                                                    <?php 
                                                        foreach ($lista_fecha as $indice => $fecha)
                                                        {
                                                           echo date( "d-m-Y", strtotime( ( $fecha ) ) ).'<br>';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        foreach ($lista_estado as $indice => $estado)
                                                        {
                                                          switch ($estado)
                                                          {
                                                                case 'P':
                                                                    echo 'PENDIENTE'.'<br>';
                                                                    break;
                                                                case 'E':
                                                                    echo 'FIRMADA'.'<br>';
                                                                    break;
                                                                 case 'F':
                                                                    echo 'EMITIDA'.'<br>';
                                                                    break;
                                                                 case 'A':
                                                                    echo 'ANULADA'.'<br>';
                                                                    break;
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                   <?php 
                                                        foreach ($lista_total as $indice => $total)
                                                        {                                                          
                                                            echo obtener_precio($total).'<br>';
                                                        }

                                                         $lista_fecha  = null;
                                                         $lista_estado = null;
                                                         $lista_total  = null;
                                                    ?>
                                                </td>
                                            </tr>
                                <?php    
                                        }
                                    }
                                ?>
                                    </tbody>
                                </table>
                                </div>


                            <?php 
                                    }
                                    else
                                    {
                                        // echo "No hay complemento";
                                    }
                                //}
                            ?>
                        <?php 
                    }else{
                       // echo "No hay OC";
                         echo '<table>';
                            echo '<tbody>';
                                echo '<tr>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                echo '</tr>';
                            echo '</tbody>';
                        echo '</table>';
                        
                        unset($oc_enlace_factura); 
                    }
                }?>
                <?php if($rc['TIPO_DOC'] == 'OC')
                      {
                ?>
                    <div class="form-inline">
                        <div class=" table-resposive">
                            <table class="table table-striped table-bordered">
                                <tbody> 
                                    <?php
                                         if ($obtener_ordenes_compras[$rc['NO_DOCUMENTO']]['ESTADO']!= 'F')
                                                        {
                                                            $clase = 'bg-warning';
                                                        }    
                                                        else
                                                        {
                                                            $clase='';
                                                        }
                                    ?>
                                    <tr class="<?php echo $clase?>">
                                        <td>
                                            <?php echo $rc['NO_DOCUMENTO'] ?> 
                                        </td>
                                        <td>
                                           <?php echo date( "d-m-Y", strtotime(($obtener_ordenes_compras[$rc['NO_DOCUMENTO']]['FECHA'])))?>
                                        </td>
                                        <td>
                                            <?php 
                                                    switch ($obtener_ordenes_compras[$rc['NO_DOCUMENTO']]['ESTADO'])
                                                    {
                                                        case 'P':
                                                            echo 'PENDIENTE';
                                                            break;
                                                        case 'E':
                                                            echo 'FIRMADA';
                                                            break;
                                                         case 'F':
                                                            echo 'EMITIDA';
                                                            break;
                                                         case 'A':
                                                            echo 'ANULADA';
                                                            break;
                                                    }
                                            ?>                                                                                          
                                        </td>
                                        <td>
                                            <?php echo obtener_precio($obtener_ordenes_compras[$rc['NO_DOCUMENTO']]['TOTAL'])?>
                                        </td>
                                    </tr>
                    <?php 
                    //Esta rutina es para determinar si existe algun complemento para desplegar en la pantalla
                        $hay_complemento =0;
                        foreach($lista_ordenes_complementarias as $key_complemento => $lo)
                        {
                            if($lo['ORDEN'] == $rc['NO_DOCUMENTO'])
                            {
                                $hay_complemento = 1;
                            }
                        }
                    //Esta rutina es para determinar si existe algun complemento para desplegar en la pantalla

                        //Si se determino que existe un complemento, se procedera a revisar cuales son y se ordenan en la tabla de los complementos
                        if ($hay_complemento == 1)
                        {
                    ?>

                                        <tr>
                                            <td>

                                                <?php 
                                                    foreach($lista_ordenes_complementarias as $key =>$lo)
                                                    {

                                                        if($lo['ORDEN'] == $rc['NO_DOCUMENTO'])
                                                        {
                                                            $doc_procesado[$key] = 1; //Array que identifica a las ordenes de compra que ya an sido procesadas para que mas adelante no las repita
                                                            $lista_fecha[] = $lo['FECHA'];
                                                            $lista_estado [] =  $lo['ESTADO']; 
                                                            $lista_total[] =  $lo['TOTAL'];
                                                 ?>
                                                        C_<?php echo $key.'<br>'?>
                                                <?php 
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    foreach ($lista_fecha as $indice => $fecha)
                                                    {
                                                        echo date( "d-m-Y", strtotime( ( $fecha ) ) ).'<br>';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                foreach ($lista_estado as $indice => $estado)
                                                    {
                                                        switch ($estado)
                                                        {
                                                            case 'P':
                                                                echo 'PENDIENTE'.'<br>';
                                                                break;
                                                            case 'E':
                                                                echo 'FIRMADA'.'<br>';
                                                                break;
                                                             case 'F':
                                                                echo 'EMITIDA'.'<br>';
                                                                break;
                                                             case 'A':
                                                                echo 'ANULADA'.'<br>';
                                                                break;
                                                        }
                                                    }
                                                ?>                                                                                          
                                            </td>
                                            <td> 
                                               <?php 
                                                    foreach ($lista_total as $indice => $total)
                                                    {
                                                        echo obtener_precio($total).'<br>';
                                                    }

                                                     $lista_fecha = null;
                                                     $lista_estado= null;
                                                     $lista_total = null;
                                                ?>
                                            </td>
                                        </tr>
                                </tbody>   
                            </table>
                        </div>
                    </div>
                    <?php
                        $hay_complemento == 0;
                        }
                        else  //Si no hay complementos de la orden de compra
                        {
                        ?>
                                </tbody>   
                            </table>
                        </div>
                    </div>   
                            
                    <?php         
                        }
                        
                        
                    ?>

                <?php }
                else
                {
                    if (($rc['TIPO_DOC'] =='FA')){
                        echo '<table>';
                            echo '<tbody>';
                                echo '<tr>';
                                    echo '<td>S/OC</td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                echo '</tr>';
                            echo '</tbody>';
                        echo '</table>';
                    }
                }

                ?>
            </td><!--Casilla de la orden de compra--> 
            
            <td style="background-color:#eeeeee;" ><!--Casilla de la orden de factura-->

                <?php 
                
                $existe_factura_relacionada = 0;
                $factura_suelta = 0;
                
                //Si se estan procesando las OC resatantes de la lista se debe consultar si tambien tienen facturas asociadas
                if ($rc['TIPO_DOC'] == 'OC')
                {
                    foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                    {
                            if($facturas_por_periodo['ORDEN'] == $rc['NO_DOCUMENTO'])
                            {
                                $existe_factura_relacionada = 1; 
                            }
                            
                            if ($facturas_por_periodo['ORDEN'] == $scAoc[$rc['NO_DOCUMENTO']])
                            {
                                 $existe_factura_relacionada = 1; 
                            }      
                    }
                }
 
                if ($rc['TIPO_DOC'] == 'FA')
                {
                    foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                    {
                            if(($facturas_por_periodo['DOCUMENTO'] == $rc['NO_DOCUMENTO']) && ($facturas_por_periodo['MONTO'] == $rc['MONTO'])) //Pertenece a una orden
                            {
                                $existe_factura_relacionada = 1;
                            }
                            else //Es una factura suelta
                            {
                                $factura_suelta = 1;
                            }
                    }
                }
                else //Se procesan las oc que estan relacionadas con las SC que pueden ser varias por celda de la tabla
                {
                    foreach ($oc_enlace_factura as $key => $valor)
                    {
                        foreach ($obtener_facturas_por_periodo as $facturas_por_periodo) // Aca se ve si esta relacionada a una orden de compra
                        {
                            if($facturas_por_periodo['ORDEN'] == $key) //Si esta relacionada con una orden de compra se dice que esta relacionada
                            {
                                $existe_factura_relacionada = 1;
                            }
                        }
                    }
                }
                
                $existencia_factura_suelta = 0;
                
                foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                {
                    if(($facturas_por_periodo['DOCUMENTO'] == $rc['NO_DOCUMENTO']) && !mb_stristr($rc['ESTADO'],'F-IRR'))
                    {
                         $existencia_factura_suelta = 1;
                    }
                }
                
                
                foreach ($obtener_facturas_sueltas as $fac_suelta)
                {
                    if ($fac_suelta['NO_DOCUMENTO'] == $rc['NO_DOCUMENTO'])
                    {
                        $existencia_factura_suelta = 1;
                    }
                }    
                
                if (($existe_factura_relacionada == 1) || ($factura_suelta == 1))
                {
                    {    
                    
                    array($indice_factura_proveedor);
                    $indice_factura_proveedor = null;
                ?>
                <div class="form-group">
                    <div class=" table-resposive">
                        <table class="table table-striped table-bordered">
                            <?php
                                if ($linea_titulos == 1)
                                {        
                            ?>   
                            
                            <thead>
                                <tr>
                                    <th>N° OC</th>
                                    <th>N° factura</th>
                                    <th>Rut proveedor</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            
                            <?php
                                }
                            ?>                                
                            <tbody>
                                <?php 
                                    if ($rc['TIPO_DOC'] == 'OC')//Cuando el origen de las facturas es una OC sin relacion con una SC
                                    { 
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $rc['NO_DOCUMENTO']?> 
                                    </td>
                                    <td>
                                    <?php 
                                    array($proveedores);
                                    $proveedores=null;
                                    foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                                    {
                                        if($facturas_por_periodo['ORDEN'] == $rc['NO_DOCUMENTO'])
                                        {
                                            $indice_factura_proveedor[$facturas_por_periodo['DOCUMENTO' ]] = $facturas_por_periodo['CODIGO_PRV'];
                                            $total_por_factura[$facturas_por_periodo['DOCUMENTO' ]] = $facturas_por_periodo['TOTAL'];
                                            echo $facturas_por_periodo['DOCUMENTO'];
                                            $proveedores[$facturas_por_periodo['CODIGO_PRV']] = '1';
                                        }
                                    } 
                                    ?>
         
                                    </td>

                                    <td>
                                    <?php 
                                        foreach ($proveedores as $codigo_proveedor => $val)
                                        {
                                            echo $codigo_proveedor;        
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php 

                                            foreach ($total_por_factura as $documento => $val){
                                                echo obtener_precio($val);
                                            }
                                            $total_por_factura=null;
                                    ?>
                                    </td>
                                </tr>             
                                <?php
                                
                                    
                                
                                
                                
                                    }
                                    elseif ($rc['TIPO_DOC'] == 'FA')//Cuando el origen de las facturas es una OC sin relacion con una SC
                                    { 
                                        unset($indice_factura_proveedor);
                                ?>
                                    <tr>
                                        <td>
                                            Factura anterior a 2020 
                                        </td>
                                        <td>
                                        <?php 
                                            array($proveedores);
                                            $proveedores=null;
                                            foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                                            {
                                                if(($facturas_por_periodo['DOCUMENTO'] == $rc['NO_DOCUMENTO']) && !mb_stristr($rc['ESTADO'],'F-IRR'))
                                                {
                                                    $indice_factura_proveedor[$rc['NO_DOCUMENTO']] = $facturas_por_periodo['CODIGO_PRV'];
                                                    echo $rc['NO_DOCUMENTO'];
                                                    $proveedores[$facturas_por_periodo['CODIGO_PRV']] = '1';
                                                }
                                            }

                                            //Si el documento fué catalogado como una factura suelta, la imprime en pantalla
                                            if ($factura_suelta == 1)
                                            {
                                                foreach ($obtener_facturas_sueltas as $fac_suelta)
                                                {
                                                    if ($fac_suelta['NO_DOCUMENTO'] == $rc['NO_DOCUMENTO'])
                                                    {
                                                        $indice_factura_proveedor[$rc['NO_DOCUMENTO']] = $fac_suelta['RUT_PB'];
                                                        $total_por_factura[$fac_suelta['NO_DOCUMENTO']] = $rc['MONTO'];
                                                        echo $fac_suelta["NO_DOCUMENTO"];
                                                    }
                                                }
                                            }
                                        ?>
                                        </td>
                                        <td>

                                        <?php 
                                            foreach ($proveedores as $codigo_proveedor => $val){
                                                echo $codigo_proveedor.'<br>';
                                            }

                                            //Si el documento fué catalogado como una factura suelta, la imprime en pantalla
                                            if ($factura_suelta == 1)
                                            {
                                                foreach ($obtener_facturas_sueltas as $fac_suelta)
                                                {
                                                    if ($fac_suelta['NO_DOCUMENTO'] == $rc['NO_DOCUMENTO'])
                                                    {
                                                        $indice_factura_proveedor[$rc['NO_DOCUMENTO']] = $fac_suelta['RUT_PB'];//Se registra la factura suelta en el arreglo que se usa en los medios de pago para identificas su correspondiente medio de pago
                                                        echo $fac_suelta['RUT_PB'];    
                                                    }
                                                }
                                            }
                                        ?>
                                        </td>
                                        <td>
                                            <?php 

                                                foreach ($total_por_factura as $documento => $val){
                                                    echo obtener_precio($val);
                                                }
                                                 $total_por_factura=null;
                                            ?>
                                        </td>
                                    </tr>             
                                <?php
                                    }
                                    else //Cuando las facturas estan relacionadas a una OC que si tiene relacion con una SC
                                    {
                                        foreach ($oc_enlace_factura as $key => $valor)
                                        {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $key?>
                                        </td>
                                        <td>
                                        <?php 
                                        array($proveedores);
                                        $proveedores=null;
                                        foreach ($obtener_facturas_por_periodo as $facturas_por_periodo)
                                        {
                                            if($facturas_por_periodo['ORDEN'] == $key)
                                            {

                                                $indice_factura_proveedor[$facturas_por_periodo['DOCUMENTO' ]]= $facturas_por_periodo['CODIGO_PRV'];
                                                $total_por_factura[$facturas_por_periodo['DOCUMENTO' ]]=$facturas_por_periodo['TOTAL' ]
                                        ?>
                                            <?php echo $facturas_por_periodo['DOCUMENTO']?>
                                        <?php
                                                $proveedores[$facturas_por_periodo['CODIGO_PRV']] = $facturas_por_periodo['TOTAL'];
                                            }
                                        }
                                        ?>
                                        </td>
                                        <td>
                                        <?php 
                                            foreach ($proveedores as $codigo_proveedor => $val){
                                                echo $codigo_proveedor.'<br>';
                                            }
                                        ?>
                                        </td>

                                        <td>
                                          <?php 
                                            foreach ($total_por_factura as $documento => $val){
                                                echo obtener_precio($val);
                                            }
                                             $total_por_factura=null;
                                        ?>

                                        </td>
                                    </tr>             
                                    <?php
                                    
                                    //SE IMPRIMEN LOS NUMEROS DE DPCUMENTO Y CEROS EN LOS MONTOS
                                    
                                            foreach ($lista_de_lineas_a_imprimir as $indice => $fecha)
                                            {
                                                echo ("<tr>");
                                                    echo ("<td>");
                                                        echo $key;
                                                    echo ("</td>");

                                                    echo ("<td>");
                                                    echo ("</td>");

                                                    echo ("<td>");
                                                    echo ("</td>");

                                                    echo ("<td>");
                                                        echo 0;
                                                    echo ("</td>");
                                                echo ("</tr>");       
                                            } 
                                    //SE IMPRIMEN LOS NUMEROS DE DPCUMENTO Y CEROS EN LOS MONTOS
                                        }
                                    }
                                        $hay_notas_credito = 0;
                                        foreach ($indice_factura_proveedor as $documento => $codigo_prv)
                                        {
                                            foreach ( $notas_credito as $key => $nc)
                                            { 

                                                foreach ($nc as $key => $nc_individual)
                                                {                                                                                                   
                                                    if ($nc_individual['documento_ref'] == $documento)
                                                    { 
                                                         $hay_notas_credito = 1;
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($hay_notas_credito == 1)
                      {
                ?>
            <!--    <strong>
                    Lista de notas de creditos
                </strong> -->

                <div class="form-group">
                    <div class=" table-resposive">
                        <table class="table table-striped table-bordered">
                           <?php
                                if ($linea_titulos == 1)
                                {        
                            ?>       
                            <thead>
                                <tr>
                                    <th>Factura</th>
                                    <th>Proveedor</th>
                                    <th>Nota credito</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <?php
                                }
                            ?>
                            <tbody>
                     <?php
                        foreach ($indice_factura_proveedor as $documento => $codigo_prv)
                        {
                    ?>       
                        <tr>
                            <?php 

                            foreach ( $notas_credito as $key => $nc)
                            { 
                                foreach ($nc as $key2 => $nc_individual)
                                {
                                    if ($nc_individual['documento_ref'] == $documento)
                                    {
                                    ?>
                                        <td>
                                            <?php echo $documento?> 
                                        </td>
                                        <td>
                                          <?php echo $codigo_prv?>
                                        </td>

                                        <td><?php 
                                                    echo $key;
                                            ?>
                                        </td>
                                        <td><?php echo obtener_precio($nc_individual['monto'])?></td>
                                    </tr>        
                            <?php 
                                   }
                                }
                            }
                        }
                     ?>
                        </tbody>   
                    </table>
                </div>
            </div>
            <?php 
                    }
                    
                } // Segundo IF
                } // Primer IF
                else{

                    echo '<table>';
                        echo '<tbody>';
                            echo '<tr>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                            echo '</tr>';
                        echo '</tbody>';
                    echo '</table>';   
                }
                
            ?>
            </td>
            <td>
                <?php 
                    $existe_forma_pago = 0;
                    foreach ($indice_factura_proveedor as $documento => $codigo_prv)
                    {
                        foreach ( $obtener_cheques as $cheque)
                        { 

                            if (($cheque['DOCUMENTO'] == $documento) && $cheque['CODIGO_PRV'] == $codigo_prv)
                            {
                                $existe_forma_pago= 1;

                            }
                        }
                    }

                    if ($existe_forma_pago == 1)
                    {
                ?>
                        <div class="form-group">
                            <div class=" table-resposive">
                                <table class="table table-striped table-bordered">
                                <?php
                                    if ($linea_titulos == 1)
                                    {        
                                ?>          
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Proveedor</th>
                                            <th nowrap>Medio de pago</th>
                                            <th >Fecha emisión</th>
                                            <th>N°</th>
                                            <th>Monto</th>

                                        </tr>
                                    </thead>
                                <?php
                                    }       
                                ?>             
                                    <tbody>
                             <?php

                                foreach ($indice_factura_proveedor as $documento => $codigo_prv)
                                {
                            ?>       
                                    <?php 
                                        foreach ( $obtener_cheques as $cheque)
                                        { 

                                           if (($cheque['DOCUMENTO'] == $documento) && $cheque['CODIGO_PRV'] == $codigo_prv)
                                           {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $documento;?> 
                                            </td>
                                            <td>
                                                <?php echo $codigo_prv?>
                                            </td>
                                            <td><?php echo $cheque['TIPO_DOCUMENTO_ENL']?></td>
                                            <td><?php echo date( "d-m-Y", strtotime( ( $cheque['FECHA_EMISION'] ) ) )?></td>
                                            
                                            <td>
                                                 <?php 
                                                    if( $cheque['TIPO_DOCUMENTO_ENL'] == 'TRANS')
                                                    {
                                                       $numero_documento = $cheque['CORRELATIVO'];
                                                    }
                                                    else
                                                    {
                                                       $numero_documento = $cheque['DOCUMENTO_ENL'];  
                                                    }
                                                    echo $numero_documento;?>
                                            </td>
                                            <td><?php echo obtener_precio($cheque['MONTO_ENL'])?></td>
                                        </tr>        
                            <?php 
                                             //SE IMPRIMEN LOS NUMEROS DE DPCUMENTO Y CEROS EN LOS MONTOS
                                    
                                                foreach ($lista_de_lineas_a_imprimir as $indice => $fecha)
                                                {
                                                    echo ("<tr>");
                                                        echo ("<td>");
                                                            echo $documento;
                                                        echo ("</td>");

                                                        echo ("<td>");
                                                        echo ("</td>");

                                                        echo ("<td>");
                                                        echo ("</td>");
                                                        echo ("<td>");
                                                        echo ("</td>");
                                                        echo ("<td>");
                                                        echo ("</td>");

                                                        echo ("<td>");
                                                            echo 0;
                                                        echo ("</td>");
                                                    echo ("</tr>");       
                                                } 
                                        //SE IMPRIMEN LOS NUMEROS DE DPCUMENTO Y CEROS EN LOS MONTOS
                                            }
                                       }
                                }
                                $indice_factura_proveedor = null;
                             ?>
                            </tbody>   
                        </table>
                    </div>
                </div>
                <?php 
                     }
                     else
                     {
                         //echo "No existe forma de pago";
                        echo '<table>';
                            echo '<tbody>';
                                echo '<tr>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                echo '</tr>';
                            echo '</tbody>';
                        echo '</table>';
                     }
               ?>
            </td>
     </tr>
        <?php
                    }
                }
                $linea_titulos++;
                unset($lista_de_lineas_a_imprimir);
            }  
        ?>
        </tbody>
     
    </table>
</div>

<?php

}

function generar_xls_contrataciones($obtener_cheques,$idProyecto,$nombreProyecto,$centro_costo,$ano,$mes)
{
                $suma_boletas  = 0;
                $suma_facturas = 0;
                $nombre_archivo = 'Reporte_Pagos_Proyecto_'.$idProyecto.'_'.$mes.'-'.$ano.'.xls';
          
                $idProyecto                                         = $_SESSION['tmp']["idProyecto"];
                $nombreProyecto                                     = $_SESSION['tmp']["nombreProyecto"];
                $centro_costo                                       = $_SESSION['tmp']["centro_costo"];
               
                $mes                                                = $_SESSION['tmp']["mes_seleccion"];
                $ano                                                = $_SESSION['tmp']["ano_seleccion"];

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"".$nombre_archivo."\";");
		header('Pragma: private'); // allow private caching
		echo'<meta http-equiv="Content-type" content="text/html;charset=iso8859-1" /> ';
                
                echo '<table border =1>';
		echo    '<thead>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'CENTRO DE COSTO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $centro_costo ;
		echo            '</th>';
		echo        '</tr>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'ITEM PRESUPUESTARIO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $idProyecto ;
		echo            '</th>';
		echo        '</tr>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'PROYECTO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $nombreProyecto;
		echo            '</th>';
		echo        '</tr>';
		echo    '</thead>';
		echo '</table>';
                           
		echo '<br>';
                
                echo '<table border =1>';
		echo    '<thead>';
		echo        '<tr>';
		echo            '<th align="center" colspan=9>';
		echo                'Reporte de contratos';
		echo            '</th>';
		echo        '</tr>';
		echo    '</thead>';
		echo '</table>';
                
                echo '<br>';
                
	
 ?>


<?php


        $rs_obtener_contrataciones_boletas = obtener_contrataciones_boletas('LS',$idProyecto, $centro_costo, $mes, $ano);

        $obtener_contrataciones_boletas  = convertir_rs_a_array($rs_obtener_contrataciones_boletas);

?>
   <div class="table-resposive">
    <div class="col-lg-12 col-md-12 col-sd-12 col-xs-12 ">
         <table id="tabla_contenedora_reporte_contrataciones" class="table table-bordered table-striped" border =1>
             <thead>
                 <tr>
                     <th>N° Contrato</th>
                     <th>Monto Contrato</th>
                     <th>Rut</th>
                     <th>Nombre</th>
                     <th>N° documento</th>
                     <th>Tipo documento</th>
                     <th>Detalle documento</th>
                     <th>Fecha recepcion</th>
                     <th>Monto</th>
                 </tr>
             </thead>

             <tbody>
             <?php 
                 $suma_total_remuneraciones = 0;
                 $suma_total_contratos = 0;

                    foreach ($obtener_contrataciones_boletas as $key => $data)                                                   
                    {
                        if ($data['tipo_doc']== 'RE')
                        {
                            $suma_total_remuneraciones = $suma_total_remuneraciones + $data['monto'];
                        }
                        if ($data['tipo_doc']== 'CN')
                        {
                            $suma_total_contratos = $suma_total_contratos + $data['monto'];

                        }
                        //Devengado
                        if ($data['tipo_doc']=='RE' && $data['tipo']=='E')
                        {
                            $devengado_remuneraciones = $devengado_remuneraciones + $data['monto'];
                        }
                        if ($data['tipo_doc']=='BO' && $data['tipo']=='E') 
                        {
                            $devengado_boletas = $devengado_boletas + $data['monto'];
                        }
                        if ($data['tipo_doc']=='ND' && $data['tipo']=='E')
                        {
                            $devengado_viaticos = $devengado_viaticos + $data['monto'];
                        }
             ?>    
                 <tr>
                     <td ><?php echo $data['GLS_CONTRATO']?></td>
                     <td ><?php echo obtener_precio($data['MONTO_CONTRATO'])?></td>
                     <td ><?php echo $data['RUT']?></td>
                     <td ><?php echo $data['NOMBRE']?></td>
                     <td ><?php echo $data['DOCUMENTO']?></td>
                     <td ><?php echo $data['TIPO_DOCUMENTO']?></td>
                     <td ><?php echo $data['NMB_DOCUMENTO']?></td>
                     <td data-sort="<?php echo date( 'Y/m/d', strtotime( ( $data['FEC_RECEPCION'] ) ) )?>" ><?php echo date( 'd-m-Y', strtotime( ( $data['FEC_RECEPCION'] ) ) )?></td>
                     <td ><?php echo obtener_precio($data['TOTAL'])?></td>
                 </tr>

             <?php  
                     }

             ?>    
             </tbody>
             <tfoot>
                 <tr class="nohover"> 
                     <th>N° Contrato</th>
                     <th>Monto Contrato</th>
                     <th>Rut</th>
                     <th>Nombre</th>
                     <th>N° documento</th>
                     <th>Tipo documento</th>
                     <th>Detalle documento</th>
                     <th>Fecha recepcion</th>
                     <th>Monto</th>
                  </tr>
             </tfoot>   
        </table>
    </div>
</div>
        

<?php

}

function generar_xls_boletas($obtener_cheques,$idProyecto,$nombreProyecto,$centro_costo,$ano,$mes)
{
                $suma_boletas  = 0;
                $suma_facturas = 0;
                $nombre_archivo = 'Reporte_Pagos_Proyecto_'.$idProyecto.'_'.$mes.'-'.$ano.'.xls';
          
                $idProyecto                                         = $_SESSION['tmp']["idProyecto"];
                $nombreProyecto                                     = $_SESSION['tmp']["nombreProyecto"];
                $centro_costo                                       = $_SESSION['tmp']["centro_costo"];
               
                $mes                                                = $_SESSION['tmp']["mes_seleccion"];
                $ano                                                = $_SESSION['tmp']["ano_seleccion"];

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"".$nombre_archivo."\";");
		header('Pragma: private'); // allow private caching
		echo'<meta http-equiv="Content-type" content="text/html;charset=iso8859-1" /> ';
                
                echo '<table border =1>';
		echo    '<thead>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'CENTRO DE COSTO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $centro_costo ;
		echo            '</th>';
		echo        '</tr>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'ITEM PRESUPUESTARIO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $idProyecto ;
		echo            '</th>';
		echo        '</tr>';
		echo        '<tr>';
		echo            '<th align="left">';
		echo                'PROYECTO: ';
		echo            '</th>';
		echo            '<th align="left">';
		echo                $nombreProyecto;
		echo            '</th>';
		echo        '</tr>';
		echo    '</thead>';
		echo '</table>';
                           
		echo '<br>';
                
                echo '<table border =1>';
		echo    '<thead>';
		echo        '<tr>';
		echo            '<th align="center" colspan=8>';
		echo                'Reporte de pagos';
		echo            '</th>';
		echo        '</tr>';
		echo    '</thead>';
		echo '</table>';
                
                echo '<br>';
                
	
 ?>


<?php

        $rs_obtener_contrataciones_boletas = obtener_contrataciones_boletas('LS',$idProyecto, $centro_costo, $mes, $ano);
        $obtener_contrataciones_boletas  = convertir_rs_a_array($rs_obtener_contrataciones_boletas);
        //debug($obtener_contrataciones_boletas);
        $array_boletas = array();
        
        foreach ($obtener_contrataciones_boletas as $boleta)
        {
            $monto_contrato = $boleta['MONTO_CONTRATO'];
            $numero_contrato= $boleta['GLS_CONTRATO'];
            $f_inicio       = $boleta['FECHA_DESDE'];
            $f_termino      = $boleta['FECHA_TERMINO'];
            $cod_prov       = $boleta['CODIGO_PRV'];
            $nombre         = $boleta['NOMBRE'];
            $monto_pagado_acumulado =  $array_boletas[$cod_prov][$numero_contrato]['MONTO_PAGADO_ACUMULADO'] +  $boleta["TOTAL_OC"];         
           // debug($boleta);
            
           
            $array_boletas[$cod_prov][$numero_contrato]['CODIGO_PRV']                 = $cod_prov ;
            $array_boletas[$cod_prov][$numero_contrato]['NOMBRE']                     = $nombre ;
            $array_boletas[$cod_prov][$numero_contrato]['MONTO_CONTRATO']             = $monto_contrato ;
            $array_boletas[$cod_prov][$numero_contrato]['GLS_CONTRATO']               = $numero_contrato ;
            $array_boletas[$cod_prov][$numero_contrato]['FECHA_DESDE']                = $f_inicio ;
            $array_boletas[$cod_prov][$numero_contrato]['FECHA_TERMINO']              = $f_termino ;
            $array_boletas[$cod_prov][$numero_contrato]['MONTO_PAGADO_ACUMULADO']     = $monto_pagado_acumulado ;
             
        }
        
     //   debug($array_boletas);
 
?>
   <div class="table-resposive">
    <div class="col-lg-12 col-md-12 col-sd-12 col-xs-12 ">
         <table id="tabla_contenedora_reporte_boletas" class="table table-bordered table-striped" border="1">
             <thead>
                <tr>
                    <th>Monto Contrato</th>
                    <th>N° Contrato</th>
                    <th>Inicio</th>
                    <th>Termino</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Saldo</th>
                </tr>
             </thead>

             <tbody>
             <?php 
                 $suma_total_remuneraciones = 0;
                 $suma_total_contratos = 0;

                    foreach ($array_boletas as $boletas)
                    { 
                        foreach ($boletas as $key => $data)
                        { 
                       
             ?>    
                 <tr>
                     <td ><?php echo obtener_precio($data['MONTO_CONTRATO'])?></td>
                     <td ><?php echo $data['GLS_CONTRATO']?></td>
                     <td ><?php echo date( "d-m-Y", strtotime( ( $data['FECHA_DESDE'] ) ) )?></td>
                     <td ><?php echo date( "d-m-Y", strtotime( ( $data['FECHA_TERMINO'] ) ) )?></td>
                     <td ><?php echo $data['CODIGO_PRV']?></td>
                     <td ><?php echo $data['NOMBRE']?></td>
                     <td ><?php echo obtener_precio($data['MONTO_PAGADO_ACUMULADO'])?></td>
                     <td ><?php echo obtener_precio($data['MONTO_CONTRATO'] - $data['MONTO_PAGADO_ACUMULADO'])?></td>
                 </tr>

             <?php  
             
                        }
                    }

             ?>    
             </tbody>
             <tfoot>
                 <tr class="nohover"> 
                    <th>Monto Contrato</th>
                    <th>N° Contrato</th>
                    <th>Inicio</th>
                    <th>Termino</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Saldo</th>
                  </tr>
             </tfoot>   
        </table>
    </div>
       
       
       
</div>
        
<br>
 <?php
        echo '<strong>Solicitud de Compra:</strong>';
          //  if (count($reporte_compras_solicitudes_anuladas) > 0)
            {

                echo '<table border =1>';
		echo    '<tbody>';
		
                    foreach ($reporte_compras_solicitudes_anuladas as $solicitud_anulada)
                    {
                       echo "<tr>";
                            echo "<td>";
                            echo '<strong>Solicitud de Compra:</strong>';
                                echo '<table style="background-color: #669999">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>N°Solicitud</th>';
                                            echo '<th nowrap>Fecha creación</th>';
                                            echo '<th>Tipo solicitud</th>';
                                            echo '<th>Estado</th>';
                                            echo '<th>Monto</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                        echo '<tr>';
                                            echo '<td>';
                                                echo $solicitud_anulada["NO_DOCUMENTO"];
                                            echo '</td>';

                                            echo '<td>';
                                                echo $solicitud_anulada["FECHA"];
                                            echo '</td>';

                                            echo '<td>';
                                                 echo 'SOLICITUD DE COMPRA';
                                            echo '</td>';

                                            echo '<td>'; 
                                                echo 'ANULADA';
                                            echo '</td>';

                                            echo '<td>';
                                                echo obtener_precio(abs($solicitud_anulada["MONTO"]));
                                            echo '</td>';

                                        echo '</tr>';
                                    echo '</tbody>';
                                echo '</table>';

                            echo "</td>";

                            echo "<td><strong>Ordenes de compra relacionadas:</strong></td>";
                            echo "<td><strong>Lista de facturas relacionadas con ordenes de compra:</strong></td>";
                            echo "<td><strong>Faturas asociadas a la forma de pago:</strong></td>";
                       echo "</tr>";
                    }

		echo    '</body>';
		echo '</table>';
                           
		echo '<br>';
                
            }
?>

<?php

}
?>