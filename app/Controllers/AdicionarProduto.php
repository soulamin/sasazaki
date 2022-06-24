<?php 

    namespace App\Controllers;

use App\Models\ProdutosModel;

    class AdicionarProduto extends BaseController
    {
        protected $db;
        public function __construct()
        {
            $this->db = \Config\Database::connect("testeInsert");            
        }

        public function importarProduto() {
            $model = new ProdutosModel("testeInsert");
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://portobello.deltacode.com.br/api/produto/'.$this->totem_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c',
                'Cookie: ci_session=pftop6p6qvk5jf9jlsq2b5gborcpvfbo'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $produtos = json_decode($response);
            
            if (count($produtos->data) == 0){
                echo "não há atualizações";
                return;
            }
            
            $model->truncateTable("truncate table produtos");

            foreach($produtos->data as $produto) {
                $produto->last_update_date = date('Y-m-d');
                $model->insert($produto);
            }
            $this->informarAtualizacao($produtos->lista);
            
            $db = \Config\Database::connect();
            $builderAtualizacao = $db->table('atualizacao');
            $newAtualizacao = [
                "dataatualizacao" => date('Y-m-d H:i:s')
            ];

            $builderAtualizacao->insert((array)$newAtualizacao);
        }

        public function informarAtualizacao($idLista) {
            

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://portobello.deltacode.com.br/api/atualizar-produto/'.$idLista,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c',
                'Cookie: ci_session=pftop6p6qvk5jf9jlsq2b5gborcpvfbo'
                ),
            ));

            curl_exec($curl);
            echo "produtos atualizados";
        }

        public function importarGroupImages() {            
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://portobello.deltacode.com.br/api/group-images',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 087811c0ba549d21a92c6abca06c4795cb643ce1198e3d6d00548b333e31756db642bff32a7482509d4eedd8cab2cbd3cfe4f02cb75b1dabc7a654230b119f7c',
                'Cookie: ci_session=pftop6p6qvk5jf9jlsq2b5gborcpvfbo'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $items = json_decode($response);
            
            if (count($items) == 0){
                echo "não há atualizações";
                return;
            }
            
            foreach($items as $item) {
                $this->validaGroupImage($item);
            }
            $this->baixarGroupImages();
            return "Group Images atualizados";
        }

        private function validaGroupImage($newItem) {
            $builder = $this->db->table('group_images');
    
            $item = $builder->getWhere(['id' => $newItem->id])->getRow();
            if ($item == null) {
                $builder->insert((array)$newItem);
            } else {
                $builder->update((array)$newItem, ["id" => $item->id]);
            }
        } 
        
        private function createRepository($arrPath) {
            $init = '';
            foreach($arrPath as $path) {
                $init .= "\\".$path;
                if (!is_dir(__DIR__."\\..\\..\\public\\uploads".$init)){
                    mkdir(__DIR__."\\..\\..\\public\\uploads".$init);
                }
            }
        }

        public function baixarGroupImages() {
            $builder = $this->db->table('group_images');
            $items = $builder->get()->getResult();

            foreach($items as $item) {
                if ($item->mainImage == null) {
                    continue;
                }

                $arrPath = explode("/", $item->mainImage);
                $this->createRepository(array_splice($arrPath,0, (count($arrPath) - 1)));

                $url = "http://digital.portobello.com.br/uploads".$item->mainImage;
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
                $img = str_replace("/", "\\", $item->mainImage);
                $img = substr($img, 0, stripos($img, "?"));
                file_put_contents(__DIR__."\\..\\..\\public\\uploads".$img,$return); 
            }
        }

        public function baixarImagesProdutos() {
            $builder = $this->db->table('produtos');
            $items = $builder->get()->getResult();
            foreach($items as $item) {
                if ($item->zoomImage == null || $item->zoomImage == '') {
                    continue;
                }

                $arrPath = explode("/", $item->zoomImage);
                $this->createRepository(array_splice($arrPath,0, (count($arrPath) - 1)));

                $url = "http://digital.portobello.com.br/uploads".$item->zoomImage;
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
                $img = str_replace("/", "\\", $item->zoomImage);
                if (mb_strpos($img, "?") != false) {
                    $img = substr($img, 0, stripos($img, "?"));
                }
                file_put_contents(__DIR__."\\..\\..\\public\\uploads".$img,$return); 
            }

            echo "Imagens dos Produtos Atualizados";
        }

    }