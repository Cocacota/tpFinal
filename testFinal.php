<?php
include_once "baseDatos.php";
include_once "empresa.php";
include_once "Pasajero.php";
include_once "Responsble.php";
include_once "Viaje.php";
$bandera=true;
do{
    echo "----------MENU PRINCIPAL---------------\n";
    echo "---------opciones de añadir------------\n";
    echo "1. para añadir una empresa.------------\n";
    echo "2. para añadir un empleado ------------\n";
    echo "3. para añadir un viaje----------------\n";
    echo "4. para añadir un  pasajero------------\n";
    echo "--------opciones de modificar----------\n";
    echo "5. para modificar una empresa----------\n";
    echo "6. para modificar un empleado----------\n";
    echo "7. para modificar un viaje-------------\n";
    echo "8. para modificar un pasajero----------\n";
    echo "----------opciones para eliminar-------\n";
    echo "9. para eliminar una empresa-----------\n";
    echo "10. para eliminar un empleado----------\n";
    echo "11. para eliminar un viaje-------------\n";
    echo "12. para eliminar un pasajero----------\n";
    echo "---------opciones mostrar--------------\n";
    echo "13. para mostrar las empresas----------\n";
    echo "14. para mostrar los empleados---------\n";
    echo "15. para mostrar los viajes------------\n";
    echo "16. para mostrar los pasajeros---------\n";
    echo "---------------------------------------\n";
    echo "17. para salir-------------------------\n";
    $opcion= entreNumeros(1,17);
    switch($opcion){
        case 1:
            añadirEmpresa();
            break;
        case 2:
            añadirEmpleado();
            break;
        case 3:
            añadirViaje();
            break;
        case 4:
            añadirPasajero();
            break;
        case 5:
            modificarEmpresa();
            break;
        case 6:
            modificarEmpleado();
            break;
        case 7:
            modificarViaje();
            break;
        case 8:
            modificarPasajero();
            break;
        case 9:
            eliminarEmpresa();
            break;
        case 10:
            eliminarEmpleado();
            break;
        case 11:
            eliminarViaje();
            break;
        case 12:
            eliminarPasajero();
            break;
        case 13:
            mostrarEmpresa();
            break;
        case 14:
            mostrarEmpleado();
            break;
        case 15:
            mostrarViaje();
            break;
        case 16:
            mostrarPasajero();
            break;
        case 17:
            $bandera=false;
            break;
    }

}while($bandera);

function entreNumeros($a,$b){
    $n=trim(fgets(STDIN));
    while($n<$a||$n>$b){
        echo "ingrese un numero entre ".$a." y ".$b."\n";
        $n=trim(fgets(STDIN));
    }
    return $n;
}
//funciones de añadir
function añadirEmpresa(){
    $empresa=new empresa();
    echo "----------MENU AÑADIR EMPRESA----------\n";
    echo "ingrese el nombre de la empresa--------\n";
    $nom=trim(fgets(STDIN));
    echo "ingrese la direccion de la empresa-----\n";
    $dir=trim(fgets(STDIN));
    $empresa->cargar(null,$nom,$dir);
    if($empresa->insertar()){
        echo "la empresa se cargo con exito----------\n";
    }else{
        echo "la empresa no pudo ser cargada---------\n";
    }
}

function añadirEmpleado(){
    $empleado=new Reesponsable();
    echo "---------MENU AÑADIR EMPLEADO----------\n";
    echo "ingrese el nombre del empleado---------\n";
    $nom=trim(fgets(STDIN));
    echo "ingrese el apellido del empleado-------\n";
    $ape=trim(fgets(STDIN));
    echo "ingrese el numero de licencia----------\n";
    $lic=trim(fgets(STDIN));
    $empleado->cargar(null,$lic,$nom,$ape);
    if($empleado->insertar()){
        echo "el empleado fue cargado con exito------\n";
    }else{
        echo "el empleado no pudo ser cargado--------\n";
    }
}

function añadirViaje(){
    $viaje=new viaje;
    $empresa=new empresa();
    $empleado=new Reesponsable();
    if($empresa->listar()==[]||$empleado->listar()==[]){
        echo "no se puede crear viaje sin empresa o empleado\n";
    }else{
    echo "----------MENU AÑADIR VIAJE------------\n";
    echo "ingrese el destino del viaje-----------\n";
    $dest=trim(fgets(STDIN));
    echo "ingrese la cantidad de pasajeros-------\n";
    $cantMax=trim(fgets(STDIN));
    do{
        echo "seleccione un responsable -------------\n";
        mostrarEmpleado();
        $nroEmple=trim(fgets(STDIN));
        
    }while(!$empleado->buscar($nroEmple));
    do{
        echo "seleccione una empresa-----------------\n";
        mostrarEmpresa();
        $idEmpresa=trim(fgets(STDIN));
        
    }while(!$empresa->Buscar($idEmpresa));
    echo "ingres el importe del viaje------------\n";
    $impo=trim(fgets(STDIN));
    $viaje->cargar(null,$dest,$cantMax,$empresa,$empleado,$impo);
    if($viaje->insertar()){
        echo "el viaje fue cargado con exito-----\n";
    }else{
        echo "el viaje no puedo ser cargado------\n";
    }
    }
}

function añadirPasajero(){
    $pasajero=new pasajero();
    $viaje=new viaje();
    $colviaje=$viaje->listar();
    if($colviaje==[]){
        echo "no hay viajes, primero añada un viaje\n";
}else{
    echo "----------MENU AÑADIR PASAJERO---------\n";
    do{
        echo "ingrese el numero de documento---------\n";
        $nroDoc=trim(fgets(STDIN));
    }while($pasajero->Buscar($nroDoc));
    echo "ingrese el nombre del pasajero---------\n";
    $nom=trim(fgets(STDIN));
    echo "ingrese el apellido del pasajero-------\n";
    $ape=trim(fgets(STDIN));
    echo "ingrese el numero de telefono----------\n";
    $tel=trim(fgets(STDIN));
    do{
        echo "seleccione el viaje al que pertenece---\n";
        mostrarViaje();
        $idViaje=trim(fgets(STDIN));
        
    }while(!$viaje->Buscar($idViaje));
    $viaje->Buscar($idViaje);
    $pasajero->cargar($nroDoc,$nom,$ape,$tel,$viaje);
    if ($pasajero->insertar()){
        echo "el pasajero fue cargado con exito------\n";
    }else{
        echo "el pasajero no puedo ser cargado-------\n";
    }
}
}


//funciones de modificar
function modificarEmpresa(){
    $empresa=new empresa();
    if($empresa->listar()!=[]){
        echo "----------MENU MODIFICAR EMPRESA-------\n";
        do{
            echo "seleccione la empresa a modificar------\n";
            mostrarEmpresa();
            $idEmpresa=trim(fgets(STDIN));
        }while(!$empresa->buscar($idEmpresa));
        echo "ingrese el nuevo nombre----------------\n";
        $nom=trim(fgets(STDIN));
        echo "ingrese la nueva direccion-------------\n";
        $dir=trim(fgets(STDIN));
        $empresa->cargar($idEmpresa,$nom,$dir);
        if($empresa->modificar()){
            echo "la empresa se modifico con exito-------\n";
        }else{
            echo "no se pudo modificar la empresa--------\n";
        }

    }else{
        echo "no hay empresas cargadas actualmente---\n";
        echo "primero añada una----------------------\n";
    }
}

function modificarEmpleado(){
    $empleado=new Reesponsable();
    if($empleado->listar()!=[]){
        echo "---------MENU MODIFICAR EMPLEADO-------\n";
        do{
            echo "seleccione el dni del empleado---------\n";
            mostrarEmpleado();
            $nroEmple=trim(fgets(STDIN));
        }while(!$empleado->Buscar($nroEmple));
        echo "ingrese el nombre del empleado---------\n";
        $nom=trim(fgets(STDIN));
        echo "ingrese el apellido del empleado-------\n";
        $ape=trim(fgets(STDIN));
        echo "ingrese el numero de licencia----------\n";
        $lic=trim(fgets(STDIN));
        $empleado->cargar(null,$lic,$nom,$ape);
        if($empleado->modificar()){
            echo "el empleado fue modificado con exito---\n";
        }else{
            echo "el empleado no pudo ser modificado-----\n";
        }
    }else{
        echo "no hay empleados cargados";
    }
}

function modificarViaje(){
$viaje=new viaje();
$pasajero=new pasajero();
if($viaje->listar()!=[]){
    echo "----------MENU MODIFICAR VIAJE---------\n";
    do{
        echo "ingrese el id del viajea modificar-----\n";
        mostrarViaje();
        $idViaje=trim(fgets(STDIN));
    }while(!$viaje->Buscar($idViaje));
    echo "ingrese el destino del viaje----------\n";
    $dest=trim(fgets(STDIN));
    echo "ingrese la cantidad maxima de pasajeros\n";
    $cantMax=trim(fgets(STDIN));
    $empresa=new empresa();
    do{
        echo "seleccione la nueva empresa------------\n";
        mostrarEmpresa();
        $idEmpresa=trim(fgets(STDIN));
        
    }while(!$empresa->buscar($idEmpresa));
    $empleado=new Reesponsable();
    do{
        echo "seleccione el numero del encargado-----\n";
        mostrarEmpleado();
        $nroEmple=trim(fgets(STDIN));
        
    }while(!$empleado->Buscar($nroEmple));
    echo "ingrese el importe del viaje---------\n";
    $impo=trim(fgets(STDIN));
    $viaje->cargar($idViaje,$dest,$cantMax,$empresa,$empleado,$impo);
    if($viaje->modificar()){
        echo "el viaje fue modificado con exito------\n";
    }else{
        echo "el viaje no pudo ser modificado--------\n";
    }
}else{
    echo "no hay ningun viaje cargado---------\n";
}
}

function modificarPasajero(){
    $pasajero=new pasajero();
    if($pasajero->listar()!=[]){
        echo "--------MENU MODIFICAR PASAJERO--------\n";
        do{
            echo "seleccione el dni del pasajero---------\n";
            mostrarPasajero();
            $nroDoc=trim(fgets(STDIN));
        }while(!$pasajero->Buscar($nroDoc));
        echo "ingrese el nuevo nombre----------------\n";
        $nom=trim(fgets(STDIN));
        echo "ingrese el nuevo apellido--------------\n";
        $ape=trim(fgets(STDIN));
        echo "ingrese el nuevo numero de telefono----\n";
        $tel=trim(fgets(STDIN));
        $idviaje=$pasajero->getViaje();
        $pasajero->cargar($nroDoc,$nom,$ape,$tel,$idviaje);
        if($pasajero->modificar()){
            echo "el pasajero se modifico con exito----\n";
        }else{
            echo "el pasajero no pudo modificarse------\n";
        }
    }else{
        echo "no hay pasajero cargados----------\n";
    }
}


//funciones de eliminar
function eliminarEmpresa(){
    $empresa=new empresa();
    $viaje=new viaje();
    $col=$empresa->listar();
    if($col!=[]){
    echo "--------MENU ELIMINAR EMPRESA----------\n";
    
    do{
        echo "seleccione que empresa a eliminar------\n";
        mostrarEmpresa();
        $idEmpresa=trim(fgets(STDIN));
    }while(!$empresa->Buscar($idEmpresa));
    if($viaje->listar("idempresa=".$idEmpresa)==[]){
        if($empresa->eliminar()){
            echo "la empresa se elimino con exito--------\n";
        }else{
            echo "la empresa no pudo eliminarse----------\n";
        }
    }else{
        echo "la empresa tiene viajes asignado ------\n";
        echo "elimine los viajes primero-------------\n";
    }
}else{
    echo "no hay empresa\n";
}

}

function eliminarEmpleado(){
    $empleado=new Reesponsable();
    $viaje=new viaje();
    $col=$empleado->listar();
    if($col!=[]){
    echo "--------MENU ELIMINAR EMPLEADO---------\n";
    
    do{
        echo "seleccione el empleado a eliminar------\n";
        mostrarEmpleado();
        $nroEmple=trim(fgets(STDIN));
    }while(!$empleado->Buscar($nroEmple));
    if($viaje->listar("rnumeroempleado=".$nroEmple)==[]){
        if($empleado->eliminar()){
            echo "el empleado se elimino con exito-------\n";
        }else{
            echo "el empleado no pudo ser eliminado------\n";
        }
    }else{
        echo "el empleado tiene viajes encargados----\n";
        echo "elimine primeros los viajes------------\n";
    }
}else{
    echo "no hay empleados\n";
}
}

function eliminarViaje(){
    $viaje=new viaje();
    $pasajero=new pasajero();
    $col=$viaje->listar();
    if($col!=[]){
    echo "--------MENU ELIMINAR VIAJE------------\n";
    
    do{
        echo "seleccione el viaje a eliminar---------\n";
        mostrarViaje();
        $idviaje=trim(fgets(STDIN));
    }while(!$viaje->Buscar($idviaje));
    $colPasajeros=$pasajero->listar("idviaje=".$idviaje);
    if($colPasajeros==[]){
        if($viaje->eliminar()){
            echo "el viaje fue eliminado con exito--------\n";
        }else{
            echo " el viaje no pudo ser eliminado---------\n";
        }
    }else{
        for($i=0;$i<count( $colPasajeros)  ;$i++){
            $colPasajeros[$i]->eliminar();
        }
        if($viaje->eliminar()){
            echo "viaje y pasajero eliminado con exito---\n";
        }else{
            echo "el viaje no pudo ser eliminado---------\n";
        }
    }
}else{
    echo "no hay viajes\n";
}
}

function eliminarPasajero(){
    $pasajero=new pasajero();
    $col=$pasajero->listar();
    if($col!=[]){
    echo "--------MENU ELIMINAR PASAJERO---------\n";
    
    do{
        echo "seleccione el pasajero a eliminar------\n";
        mostrarPasajero();
        $nroDoc=trim(fgets(STDIN));
    }while(!$pasajero->Buscar($nroDoc));
    if($pasajero->eliminar()){
        echo "el pasajero fue eliminado con exito----\n";
    }else{
        echo "el pasajero no pudo ser eliminado------\n";
    }
}else{
    echo "no hay viajes\n";
}
}


//funciones de mostrar
function mostrarEmpresa(){
    $empresa=new empresa();
    $colempresa=$empresa->listar();
    if(!$colempresa==[]){
       for($i=0;$i<count($colempresa);$i++){
        echo $colempresa[$i];
        } 
    }else{
        echo "no hay empresas\n";
    }
    
}

function mostrarEmpleado(){
    $empleado=new Reesponsable();
    $colemple=$empleado->listar();
    if(!$colemple==[]){
        for($i=0;$i<count($colemple);$i++){
        echo $colemple[$i];
        }
    }else{
        echo "no hay empleados\n";
    }
    
}

function mostrarViaje(){
    $viaje=new viaje();
    $colviaje=$viaje->listar();
    if(!$colviaje==[]){
        for($i=0;$i<count($colviaje);$i++){
        echo $colviaje[$i];
        }
    }else{
        echo "no hay viajes \n";
    }
    
}

function mostrarPasajero(){
    $pasajero=new pasajero();
    $colpasa=$pasajero->listar();
    if(!$colpasa==[]){
        for($i=0;$i<count($colpasa);$i++){
        echo $colpasa[$i];
        }
    }else{
        echo"no hay pasajeros\n";
    }
    
}