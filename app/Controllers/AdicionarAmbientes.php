<?php

namespace App\Controllers;

class AdicionarAmbientes extends BaseController {
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect("testeInsert");
    }

    public function importarAmbienteUso() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => config(App::class)->baseURL.'/api/ambiente-uso',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c',
                'Cookie: ci_session=pikaj2gcnhk7je375e7ejmhposr85ruj'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $ambientes = json_decode($response);
        foreach($ambientes as $ambiente) {
            $this->validaAmbienteUso($ambiente);
        }

        echo "Ambiente Uso atualizado";
    }

    private function validaAmbienteUso($newAmbiente) {
        $builder = $this->db->table('ambientes_uso');

        $ambiente = $builder->getWhere(['Uso_id' => $newAmbiente->Uso_id])->getRow();
        if ($ambiente == null) {
            $builder->insert((array)$newAmbiente);
        } else {
            $builder->update((array)$newAmbiente, ["Uso_id" => $ambiente->Uso_id]);
        }
    }

    public function importarAmbienteN1() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => config(App::class)->baseURL.'/api/ambiente-n1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c',
            'Cookie: ci_session=pikaj2gcnhk7je375e7ejmhposr85ruj'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $ambientes = json_decode($response);
        foreach($ambientes as $ambiente) {
            $this->validaAmbienteN1($ambiente);
        }

        echo "Ambiente N1 atualizado";
    }

    private function validaAmbienteN1($newAmbiente) {
        $builder = $this->db->table('ambientes_n1');

        $ambiente = $builder->getWhere(['N1_id' => $newAmbiente->N1_id])->getRow();
        if ($ambiente == null) {
            $builder->insert((array)$newAmbiente);
        } else {
            $builder->update((array)$newAmbiente, ["N1_id" => $ambiente->N1_id]);
        }
    }

    public function importarAmbienteN2() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => config(App::class)->baseURL.'/api/ambiente-n2',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c',
            'Cookie: ci_session=pikaj2gcnhk7je375e7ejmhposr85ruj'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $ambientes = json_decode($response);
        foreach($ambientes as $ambiente) {
            $this->validaAmbienteN2($ambiente);
        }

        echo "Ambiente N2 atualizado";
    }

    private function validaAmbienteN2($newAmbiente) {
        $builder = $this->db->table('ambientes_n2');

        $ambiente = $builder->getWhere(['N2_id' => $newAmbiente->N2_id])->getRow();
        if ($ambiente == null) {
            $builder->insert((array)$newAmbiente);
        } else {
            $builder->update((array)$newAmbiente, ["N2_id" => $ambiente->N2_id]);
        }
    }

    public function importarAmbienteN3() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => config(App::class)->baseURL.'/api/ambiente-n3',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c',
            'Cookie: ci_session=pikaj2gcnhk7je375e7ejmhposr85ruj'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $ambientes = json_decode($response);
        foreach($ambientes as $ambiente) {
            $this->validaAmbienteN3($ambiente);
        }

        echo "Ambiente N3 atualizado";
    }
    private function validaAmbienteN3($newAmbiente) {
        $builder = $this->db->table('ambientes_n3');

        $ambiente = $builder->getWhere(['N3_id' => $newAmbiente->N3_id])->getRow();
        if ($ambiente == null) {
            $builder->insert((array)$newAmbiente);
        } else {
            $builder->update((array)$newAmbiente, ["N3_id" => $ambiente->N3_id]);
        }
    }

    public function baixarImagens() {
        $builder = $this->db->table('ambientes_n2');
        $ambientes = $builder->get()->getResult();

        if (!is_dir(__DIR__."\\..\\..\\public\\uploads\\ambientes")){
            mkdir(__DIR__."\\..\\..\\public\\uploads\\ambientes");
        }

        foreach($ambientes as $ambiente) {
            if ($ambiente->N2_imagem == null) {
                continue;
            }
        
            $url = "http://digital.portobello.com.br/uploads/ambientes/".$ambiente->N2_imagem;
            $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';              
            $headers[] = 'Connection: Keep-Alive';         
            $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';         
            $user_agent = 'php';         
            $process = curl_init($url);         
            curl_setopt($process, CURLOPT_HTTPHEADER, $headers);         
            curl_setopt($process, CURLOPT_HEADER, 0);         
            curl_setopt($process, CURLOPT_USERAGENT, $user_agent);         
            curl_setopt($process, CURLOPT_TIMEOUT, 30);         
            curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);         
            curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);  
            curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);      
            $return = curl_exec($process); 
            curl_close($process);
            file_put_contents(__DIR__."\\..\\..\\public\\uploads\\ambientes\\".$ambiente->N2_imagem,$return);            
        }
    }

    public function baixarImagensN3() {
        $builder = $this->db->table('ambientes_n3');
        $ambientes = $builder->get()->getResult();

        if (!is_dir(__DIR__."\\..\\..\\public\\uploads\\ambientes")){
            mkdir(__DIR__."\\..\\..\\public\\uploads\\ambientes");
        }

        foreach($ambientes as $ambiente) {
            if ($ambiente->imagem == null) {
                continue;
            }
        
            $url = "http://digital.portobello.com.br/uploads/ambientes/".$ambiente->imagem;
            $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';              
            $headers[] = 'Connection: Keep-Alive';         
            $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';         
            $user_agent = 'php';         
            $process = curl_init($url);         
            curl_setopt($process, CURLOPT_HTTPHEADER, $headers);         
            curl_setopt($process, CURLOPT_HEADER, 0);         
            curl_setopt($process, CURLOPT_USERAGENT, $user_agent);         
            curl_setopt($process, CURLOPT_TIMEOUT, 30);         
            curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);         
            curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);  
            curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);      
            $return = curl_exec($process); 
            curl_close($process);
            file_put_contents(__DIR__."\\..\\..\\public\\uploads\\ambientes\\".$ambiente->imagem,$return);            
        }
    }
}