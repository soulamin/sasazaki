<?php

namespace App\Models;

use CodeIgniter\Model;

class AmbienteModel extends Model
{
    protected $table      = 'ev2_ambientes';
    protected $primaryKey = 'ambiente_id';
    public function todos_n2($totem = true)
    {
        $builder = $this->db->table('ambientes_n2');
        if($totem) {
            $builder->where("N2_Aparece_Totem" , 'SIM');
        }
        return $builder->join('ambientes_uso', 'ambientes_n2.Uso_id = ambientes_uso.Uso_id', 'left')
            ->join('ambientes_n1', 'ambientes_uso.N1_id = ambientes_n1.N1_id', 'left')
            ->orderBy('ambientes_n2.N1_id')
            ->orderBy('ambientes_n2.Uso_id')
            ->orderBy('N2_nome')
            ->get()
            ->getResult();
    }
    public function todos_n1()
    {
        $builder = $this->db->table('ambientes_n1');
        return $builder->get()->getResult();
    }
    public function todos_uso($unicos = false /*se deve pegar apenas valores distintos*/)
    {
        $builder = $this->db->table('ambientes_uso');
        if($unicos) $builder->groupBy('Uso_nome');
        return $builder->orderBy('Uso_nome')->get()->getResult();
    }
    public function N2_de_usoN1($uso='Residencial', $n1='Piso', $todos = false)
    {
        $builder = $this->db->table($this->table);
        if(!$todos) {
            $coluna = $n1.'Totem';
            $builder->where($coluna,'SIM');
        }
        return $builder->where('N1', $n1)
            ->like('USO',$uso)
            ->orderBy('uso', 'desc')
            ->orderBy('N2')
            ->orderBy('N3')
            ->groupBy('N2')
            ->join('ambientes_n2', 'ev2_ambientes.N2 = ambientes_n2.N2_nome', 'left')
            ->get()
            ->getResult();
    }
    public function N3_por_N2($n2, $n1, $todos = false)
    {
        $builder = $this->db->table('ambientes_n3');
        if(!$todos && $n1) {
            $coluna = $n1.'Totem';
            $builder->where($coluna,'SIM');
        }
        $builder->where('ambientes_n3.N2_id', $n2)
            ->orderBy('N3')
            ->join('ambientes_n2', 'ambientes_n3.N2_id = ambientes_n2.N2_id', 'left');
        return $builder->get()->getResult();
    }
    public function N2_por_id($n2, $uso = false, $n1 = false, $todos = false)
    {
        $builder = $this->db->table($this->table);
        if(!$todos && $n1) {
            $coluna = $n1.'Totem';
            $builder->where($coluna,'SIM');
        }
        $builder->where('ambientes_n2.N2_id', $n2)
            ->orderBy('uso', 'desc')
            ->orderBy('N2')
            ->orderBy('N3')
            ->join('ambientes_n2', 'ev2_ambientes.N2 = ambientes_n2.N2_nome', 'left');
        if($uso)
            $builder->like('USO',$uso);
        if($n1)
            $builder->where('N1', $n1);
        return $builder->get()->getResult();
    }
}