<?php
function elimina_acentos($text)
    {
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = array (
            // Espacios, puntos y comas por guion
            //'/[\., ]+/' => ' ',
 
            // Vocales
            '/\+/' => '',
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',
 
            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',
 
            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',
 
            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            // Otras letras y caracteres especiales
            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $text = preg_replace(array_keys($patron),array_values($patron),$text);
        return $text;
}
function quita_diagonal($cadena_sucia){
        $cadena_limpia=str_replace('/', '', $cadena_sucia);
        return $cadena_limpia;
}
function pon_diagonal($str_sin_diagonal){
        $str_con_diagonal =substr($str_sin_diagonal,0,4);
        $str_con_diagonal .="/";
        /*$str_con_diagonal .=*/
        if(substr($str_sin_diagonal,4,2)=='01'){
                $str_con_diagonal .="ENE";
        }elseif(substr($str_sin_diagonal,4,2)=='02'){
                $str_con_diagonal .="FEB";
        }elseif(substr($str_sin_diagonal,4,2)=='03'){
                $str_con_diagonal .="MAR";
        }elseif(substr($str_sin_diagonal,4,2)=='04'){
                $str_con_diagonal .="ABR";
        }elseif(substr($str_sin_diagonal,4,2)=='05'){
                $str_con_diagonal .="MAY";
        }elseif(substr($str_sin_diagonal,4,2)=='06'){
                $str_con_diagonal .="JUN";
        }elseif(substr($str_sin_diagonal,4,2)=='07'){
                $str_con_diagonal .="JUL";
        }elseif(substr($str_sin_diagonal,4,2)=='08'){
                $str_con_diagonal .="AGO";
        }elseif(substr($str_sin_diagonal,4,2)=='09'){
                $str_con_diagonal .="SEP";
        }elseif(substr($str_sin_diagonal,4,2)=='10'){
                $str_con_diagonal .="OCT";
        }elseif(substr($str_sin_diagonal,4,2)=='11'){
                $str_con_diagonal .="NOV";
        }elseif(substr($str_sin_diagonal,4,2)=='12'){
                $str_con_diagonal .="DIC";
        }
        $str_con_diagonal .="/";
        $str_con_diagonal .=substr($str_sin_diagonal,6,2);
        return $str_con_diagonal;
}
function contarFilas($arreglo){

        $cantidad = 0;
     
        foreach($arreglo as $elemento){
         $cantidad ++;
        }
     
        return $cantidad;
     }
?>