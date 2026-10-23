<?php
class Validate {
    
    public static function email($valor){
        if (strlen(trim($valor)) <= 0) {
           $error = true;
           return $error;
        }else{
            if (!preg_match("/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/", $valor)) {
                $error = true;
                return $error;
            }
        }
    }
    

    public static function alfabetico($valor,$caracteres){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            if (!preg_match("/^[a-zA-Zà-źÀ-Ź\\,._-]+/", $valor) || strlen($valor) > $caracteres) {
                $error = true;
                return $error;
            } 
        }
    }

    public static function alfanumerico($valor,$caracteres){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            if (!preg_match("/^[a-zA-Zà-źÀ-Ź0-9\\,._-]+/", $valor) || strlen($valor) > $caracteres) {
                $error = true;
                return $error;
            }        
        }
    }
	
	public static function alfanumerico_especiales($valor,$caracteres){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            if (!preg_match("/^[a-zA-Zà-źÀ-Ź0-9?¿\\,._-]+/", $valor) || strlen($valor) > $caracteres) {
                $error = true;
                return $error;
            }        
        }
    }
    
    public static function numerico($valor,$caracteres){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            if (!preg_match("/^[0-9]+/", $valor) || strlen($valor) > $caracteres) {
                $error = true;
                return $error;
            } 
        }
    }
    
    public static function hora($valor,$caracteres){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            if (!preg_match("/^[0-9:]+/", $valor) || strlen($valor) > $caracteres) {
                $error = true;
                return $error;
            } 
        }
    }

    public static function integer($valor,$caracteres){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            if (!preg_match("/^[1-9]+/", $valor) || strlen($valor) > $caracteres) {
                $error = true;
                return $error;
            }      
        }
    }

    public static function float($valor,$caracteres){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            if (!preg_match("/^[0-9.,]+/", $valor) || strlen($valor) > $caracteres) {
                $error = true;
                return $error;
            }
        }

    }

    public static function url($valor){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
            
            
        }
        
    }
    
    public static function fecha($valor){
        if (strlen(trim($valor)) <= 0) {
            $error = true;
            return $error;
        }else{
			
            $combo_fecha = explode("/",$valor);
            
            //año
            if (!preg_match("/^[0-9]+/", $combo_fecha[0]) || strlen($combo_fecha[0]) > 4) {
                $error = true;
                return $error;
            }    
            //mes
            if (!preg_match("/^[0-9]+/", $combo_fecha[1]) || $combo_fecha[1] > 12 || $combo_fecha[1] <= 0)  {
                $error = true;
                return $error;
            }    
            //dia
            if (!preg_match("/^[0-9]+/", $combo_fecha[2]) || $combo_fecha[2] > 31 || $combo_fecha[2] <= 0  ) {
                $error = true;
                return $error;
            }    
        }
    }
    
}

//email, alfabetico, alfanumerico, numerico, integer, float, money, url
//$resultado = Validate::numerico('bgusybd458ad8964sdfsd');
//echo $resultado
?>