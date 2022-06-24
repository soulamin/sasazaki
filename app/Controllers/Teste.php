<?php

namespace App\Controllers;

class Teste extends BaseController
{ 
    public function index()
    {
        $db = \Config\Database::connect();
        $str = file_get_contents('http://localhost/portobello/public/assets/resources/flat-collection-products.json');
        $meujson = json_decode($str);
        $cnt = 0;
        
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                echo ' - No errors';
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;
        }
        
        foreach(current($meujson) as $produto) {
            $builder = $db->table('produto');
            $inserir = (array) $produto;
            $builder->insert($inserir);
            if($db->affectedRows() <= 0)
            {
                echo 'Erro: ';
                echo $db->getLastQuery();
                echo '<br><br>';
            }
            else {
                $cnt++;
            }
            $builder->resetQuery();
        }
        /*
        foreach(current($meujson) as $relimg) {
            //$tabela = 'related-images';
            $tabela = 'related-images-landscapes';
            $builder = $db->table($tabela);
            $value = (array) $relimg;
            //$campo = "relatedImages";
            $campo = "relatedImagesLandscape";
            if(isset($value[$campo]))
                $value[$campo] = json_encode($value[$campo]);
            else
                $value[$campo] = null;
            $builder->insert($value);
            if($db->affectedRows() <= 0)
            {
                echo 'Erro: ';
                echo $db->getLastQuery();
                echo '<br><br>';
            }
            else {
                $cnt++;
            }
            $builder->resetQuery();
        }
        foreach(current($meujson) as $relimg) {
            //$tabela = 'related-images';
            $tabela = 'group_images';
            $builder = $db->table($tabela);
            $value = (array) $relimg;
            //$campo = "relatedImages";
            $campo = "_id";
            if(isset($value[$campo]))
                $value[$campo] = json_encode($value[$campo]);
            else
                $value[$campo] = null;
            $campo = "environmentImages";
            if(isset($value[$campo]))
                $value[$campo] = json_encode($value[$campo]);
            else
                $value[$campo] = null;
            $campo = "Created_date";
            if(isset($value[$campo]))
                $value[$campo] = json_encode($value[$campo]);
            else
                $value[$campo] = null;
            $campo = "__v";
            if(isset($value[$campo]))
                $value[$campo] = json_encode($value[$campo]);
            else
                $value[$campo] = null;
            $builder->insert($value);
            if($db->affectedRows() <= 0)
            {
                echo 'Erro: ';
                echo $db->getLastQuery();
                echo '<br><br>';
            }
            else {
                $cnt++;
            }
            $builder->resetQuery();
        }*/
        echo 'número de sucessos: '.$cnt;
            //$builder = $db->table('produtos');
        /*
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                echo ' - No errors';
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;
        }
        */
        //var_dump($str);
        //echo $builder->insertBatch(current($meujson));
       //var_dump(json_decode($str));
    }
}
