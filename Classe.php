<?php
class Classe implements JsonSerializable{
    protected $alunni;

    public function __construct(){
        $this->alunni = array();
    }

    public function aggiungiAlunno($a){
        array_push($this->alunni,$a);
    }

    public function getAlunni(){
        return $this->alunni;
    }

    public function JsonSerialize(){
        return $this->alunni;
    }

    public function cercaAlunno($nome) {
        foreach ($this->alunni as $alunno) {
            if ($alunno->getNome() == $nome) {
                return $alunno;
            }
        }
        return null;
    }
}