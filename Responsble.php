<?php
include_once "BaseDatos.php";
class Reesponsable{

    private $rnumeroempleado;
	private $rnumerolicencia;
	private $rnombre;
	private $rapellido;

	private $mensajeoperacion;


	public function __construct(){
	    $this->rnumeroempleado=0;
		$this->rnumerolicencia = 0;
		$this->rnombre = "";
		$this->rapellido = "";
	}

	public function cargar($rnumeroempleado,$rnumerolicencia,$Nom,$Ape){	
	    $this->setRnumeroEmpleado($rnumeroempleado);
		$this->setRnumeroLicencia($rnumerolicencia);
		$this->setRNombre($Nom);
		$this->setRApellido($Ape);
		
    }
	
    public function setRnumeroEmpleado($rnumeroempleado){
        $this->rnumeroempleado=$rnumeroempleado;
    }
    public function setRnumeroLicencia($licencia){
		$this->rnumerolicencia=$licencia;
	}
	public function setRNombre($Nom){
		$this->rnombre=$Nom;
	}
	public function setRApellido($Ape){
		$this->rapellido=$Ape;
	}
	
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getRNumeroEmpleado(){
	    return $this->rnumeroempleado;
	}
	public function getRNumeroLicencia(){
		return $this->rnumerolicencia;
	}
	public function getNombre(){
		return $this->rnombre ;
	}
	public function getApellido(){
		return $this->rapellido ;
	}
	
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	
	
	

		

	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($nro){
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable where rnumeroempleado=".$nro;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($row2=$base->Registro()){
				    $this->setRnumeroLicencia($row2['rnumerolicencia']);
				    $this->setRnumeroEmpleado($nro);
					$this->setRNombre($row2['rnombre']);
					$this->setRApellido($row2['rapellido']);
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
	    $arregloResponsable = null;
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable ";
		if ($condicion!=""){
		    $consultaResponsable=$consultaResponsable.' where '.$condicion;
		}
		$consultaResponsable.=" order by rapellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){				
				$arregloResponsable= array();
				while($row2=$base->Registro()){
				    $rnumeroempleado=$row2['rnumeroempleado'];
					$rnumerolicencia=$row2['rnumerolicencia'];
					$Nombre=$row2['rnombre'];
					$Apellido=$row2['rapellido'];
				
					$respo=new Reesponsable();
					$respo->cargar($rnumeroempleado,$rnumerolicencia,$Nombre,$Apellido);
					array_push($arregloResponsable,$respo);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloResponsable;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO responsable(rnumerolicencia, rapellido, rnombre) 
				VALUES (".$this->getRNumeroLicencia().",'".$this->getApellido()."','".$this->getNombre()."')";
		
		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setRnumeroEmpleado($id);
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
		$consultaModifica="UPDATE responsable SET rapellido='".$this->getApellido()."',rnombre='".$this->getNombre().
        "',rnumerolicencia=". $this->getRNumeroLicencia()." WHERE rnumeroempleado".$this->getRNumeroEmpleado();
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
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->getRNumeroEmpleado();
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
	    return "\nNombre: ".$this->getNombre(). "\n Apellido:".$this->getApellido()."\n numero de empleado: ".$this->getRNumeroEmpleado()."\n numero de licencia ".$this->getRNumeroLicencia()."\n";
			
	}
}
?>
