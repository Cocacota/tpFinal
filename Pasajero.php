<?php
include_once "BaseDatos.php";
class pasajero{

    private $pdocumento;
	private $pnombre;
	private $papellido;
	private $ptelefono;
	private $idViaje;

	private $mensajeoperacion;


	public function __construct(){
	    $this->pdocumento=0;
		$this->pnombre = "";
		$this->papellido = "";
		$this->ptelefono = 0;
		$this->idViaje=new viaje();
	}

	public function cargar($documento,$nom,$ape,$tel,$idV){	
	    $this->setDocumento($documento);
		$this->setNombre($nom);
		$this->setApellido($ape);
		$this->setTelefono($tel);
		$this->setViaje($idV);
    }
	
    public function setDocumento($documento){
        $this->pdocumento=$documento;
    }
	public function setNombre($Nom){
		$this->pnombre=$Nom;
	}
	public function setApellido($Ape){
		$this->papellido=$Ape;
	}
	public function setTelefono($telefono){
		$this->ptelefono=$telefono;
	}
	public function setViaje($idV){
		$this->idViaje=$idV;
	}
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

	public function getDocumento(){
	    return $this->pdocumento;
	}
	public function getTelefono(){
		return $this->ptelefono;
	}
	public function getNombre(){
		return $this->pnombre ;
	}
	public function getApellido(){
		return $this->papellido ;
	}
	public function getViaje(){
		return $this->idViaje;
	}

	
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	
	
	

		

	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consulta="Select * from pasajero where pdocumento=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){
				    $tel=($row2['ptelefono']);
				    $dni=($dni);
					$nom=($row2['pnombre']);
					$ape=($row2['papellido']);
					$viaje=new viaje();
					$idv=($viaje->Buscar($row2['idviaje']));
					$this->cargar($dni,$nom,$ape,$tel,$idv);
					
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
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from pasajero ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by papellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){				
				$arreglo= array();
				while($row2=$base->Registro()){
				    				
					$perso=new pasajero();
					$perso->Buscar($row2['pdocumento']);
					
					array_push($arreglo,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arreglo;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO pasajero(pdocumento ,papellido, pnombre,  ptelefono, idviaje) 
				VALUES (".$this->getDocumento().",'"  .$this->getApellido()."','".$this->getNombre()."',".$this->getTelefono(). ",".$this->getViaje()->getIdViaje(). ")";
		
		if($base->Iniciar()){

			if( $base->Ejecutar($consultaInsertar)){
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
		$consultaModifica="UPDATE pasajero SET papellido='".$this->getApellido()."',pnombre='".$this->getNombre()."'
                           ,ptelefono=".$this->getTelefono()." WHERE pdocumento=".$this->getDocumento();
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
				$consultaBorra="DELETE FROM pasajero WHERE pdocumento=".$this->getDocumento();
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
	    return "\nNombre: ".$this->getNombre(). "\n Apellido:".$this->getApellido()."\n DNI: ".$this->getDocumento()."\n telefono: ".$this->getTelefono()."\n";
			
	}
}
?>
