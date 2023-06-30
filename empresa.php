<?php
include_once "BaseDatos.php";
class empresa{

    private $idempresa;
	private $enombre;
	private $edireccion;

	private $mensajeoperacion;


	public function __construct(){
	    $this->idempresa=0;
		$this->edireccion = "";
		$this->enombre = "";

	}

	public function cargar($idempresa,$Nom,$direccion){	
	    $this->setIdEmpresa($idempresa);
		$this->setNombre($Nom);
		$this->setDireccion($direccion);
    }
	
    public function setIdEmpresa($idempresa){
        $this->idempresa=$idempresa;
    }
	public function setNombre($Nom){
		$this->enombre=$Nom;
	}
	public function setDireccion($dir){
		$this->edireccion=$dir;
	}
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getIdEmpresa(){
	    return $this->idempresa;
	}
	public function getNombre(){
		return $this->enombre ;
	}
	public function getDireccion(){
		return $this->edireccion ;
	}

	
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	
	
	

		

	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id){
		$base=new BaseDatos();
		$consulta="Select * from empresa where idempresa=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){
				    $this->setNombre($row2['enombre']);
				    $this->setIdEmpresa($id);
					$this->setDireccion($row2['edireccion']);
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
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
		}
		$consultaEmpresa.=" order by enombre ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){				
				$arregloEmpresa= array();
				while($row2=$base->Registro()){
				    $id=$row2['idempresa'];
					$Nombre=$row2['enombre'];
					$direccion=$row2['edireccion'];
				
					$empre=new empresa();
					$empre->cargar($id,$Nombre,$direccion);
					array_push($arregloEmpresa,$empre);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloEmpresa;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(enombre, edireccion) 
				VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
		
		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdEmpresa($id);
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
		$consultaModifica="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion()
                        ."' WHERE idempresa=".$this->getIdEmpresa();
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
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
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
	    return "\nNombre: ".$this->getNombre(). "\n direccion:".$this->getDireccion()."\n id de la empresa: ".$this->getIdEmpresa()."\n";
			
	}
}
?>
