<?php 

    namespace App\Controllers;

use App\Models\BannersModel;

    class AdicionarBanner extends BaseController
    {
        protected $db;

        public function __construct()
        {
            $this->db = \Config\Database::connect();
        }

        public function importarBanners() {
            $model = new BannersModel("testeInsert");
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => config(App::class)->baseURL.'/api/banners/'.$this->totem_id,
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
            // echo $response;
            foreach(json_decode($response) as $banner) {
                $this->validaBanners($banner);
            }

            $this->baixarImagens();
            echo "banners atualizados";
        }

        private function validaBanners($newItem) {
            $model = new BannersModel("testeInsert");
            
            $item = $model->getWhere(['id' => $newItem->id])->getRow();
            if ($item == null) {
                $model->insert((array)$newItem);
            } else {
                $model->update($item->id, (array)$newItem);
            }
        }
        public function baixarImagens() {
            $model = new BannersModel("testeInsert");
            $items = $model->get()->getResult();
            
            if (!is_dir(__DIR__."\\..\\..\\public\\uploads\\baners")){
                mkdir(__DIR__."\\..\\..\\public\\uploads\\baners");
            }

            foreach($items as $item) {
                if ($item->imagem == null) {
                    continue;
                }
    
                $url = "https://digital.portobello.com.br/uploads/baners/".$item->imagem;
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
                file_put_contents(__DIR__."\\..\\..\\public\\uploads\\baners\\".$item->imagem,$return);           
            }
        }
    }