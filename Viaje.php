<?php
include_once "baseDatos.php";
class viaje{

    private $idviaje;
	private $vdestino;
	private $vcantmaxpasajeros;
	private $empresa;
	private $empleado;
	private $vimporte;
	//private $pasajeros;
    private $mensajeoperacion;


	public function __construct(){
	    $this->idviaje=0;
		$this->vdestino = "";
		$this->vcantmaxpasajeros = "";
		$this->empresa = new empresa();
		$this->empleado = new Reesponsable();
        $this->vimporte = "";
		//$this->pasajeros=[];
	}

	public function cargar($idviaje,$vdestino,$vcantmaxpasajeros,$idempresa,$rnumeroempleado,$vimporte){	//,$pasajeros
	    $this->setIdViaje($idviaje);
		$this->setVdestino($vdestino);
		$this->setVCantMaxPasajeros($vcantmaxpasajeros);
		$this->setEmpresa($idempresa);
		$this->setEmpleado($rnumeroempleado);
        $this->setVimporte($vimporte);
		//$this->setPasajeros($pasajeros);
    }
	
    public function setIdViaje($idviaje){
        $this->idviaje=$idviaje;
    }
    public function setVdestino($vdestino){
		$this->vdestino=$vdestino;
	}
    public function setVCantMaxPasajeros($vdestino){
		$this->vcantmaxpasajeros=$vdestino;
	}
	public function setEmpresa($idempresa){
		$this->empresa=$idempresa;
	}
	public function setEmpleado($rnumeroempleado){
		$this->empleado=$rnumeroempleado;
	}
	public function setVimporte($vimporte){
		$this->vimporte=$vimporte;
	}
	/*public function setPasajeros($pasajeros){
		$this->pasajeros=$pasajeros;
	}*/
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getIdViaje(){
        return $this->idviaje;
    }
    public function getVdestino(){
		return $this->vdestino;
	}
    public function getVCantMaxPasajeros(){
	 	return $this->vcantmaxpasajeros;
	}
	public function getEmpresa(){
		return $this->empresa;
	}
	public function getEmpleado(){
		return $this->empleado;
	}
	public function getVimporte(){
		return $this->vimporte;
	}
	/*public function getPasajeros(){
		return $this->pasajeros;
	}*/

	
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	
	
	

		

	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idviaje){
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=".$idviaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($row2=$base->Registro()){
					$empresa=new empresa();
					if($empresa->Buscar($row2['idempresa'])){
						$Empresa=($empresa);
					}else{
						$Empresa=(null);
					}
				    
				    $Viaje=($idviaje);
					$Vdestino=($row2['vdestino']);
					$MaxPasajeros=($row2['vcantmaxpasajeros']);
					$empleado=new Reesponsable();
					if($empleado->Buscar($row2['rnumeroempleado'])){
						$Empleado=($empleado);
					}else{
						$Empleado=(null);
					}
                    $Vimporte=($row2['vimporte']);
					//$pasajero=new pasajero();
					//$this->setPasajeros($pasajero->listar("idviaje=".$idviaje));
					$this->cargar($Viaje,$Vdestino,$MaxPasajeros,$Empresa,$Empleado,$Vimporte);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	public  function listar($condicion=""){
	    $arregloViaje = null;
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by vdestino ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje= array();
				while($row2=$base->Registro()){
					$viaje=new viaje;
				    $viaje->Buscar($row2['idviaje']);
						
					array_push($arregloViaje,$viaje);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloViaje;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO viaje( vdestino, vcantmaxpasajeros,  idempresa, rnumeroempleado, vimporte) 
				VALUES ('".$this->getVdestino()."',".$this->getVCantMaxPasajeros().",".$this->getEmpresa()->getIdEmpresa().",".$this->getEmpleado()->getRnumeroEmpleado().",".$this->getVimporte().")";
		
		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdViaje($id);
			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getVdestino()."',vcantmaxpasajeros=".$this->getVCantMaxPasajeros()."
                           ,idempresa=".$this->getEmpresa()->getIdEmpresa().",rnumeroempleado=". $this->getEmpleado()->getRNumeroEmpleado(). ",vimporte=".$this->getVimporte(). " WHERE idviaje=".$this->getIdViaje();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getIdViaje();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

	public function __toString(){
		$m="";
		$pasajero=new pasajero();
		for($i=0;$i<count($pasajero->listar("idviaje=".$this->getIdViaje()));$i++){
			$m.=$pasajero->listar("idviaje=".$this->getIdViaje())[$i]."\n";
		}
	    return "\nId del viaje: ".$this->getIdViaje(). "\n destino del viaje:".$this->getVdestino()."\n cantidad de pasajeros maxima: ".$this->getVCantMaxPasajeros()."\n la empresa encargada". $this->getEmpresa()."\n Empleado encargado".$this->getEmpleado(). "\n importe". $this->getVimporte()."\n". $m ;
			
	}
}
?>
