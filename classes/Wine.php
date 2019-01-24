<?php

require_once 'DB.php';
/**
 * Description of Wine
 *
 * @author pedro
 */
class Wine {
    private $db;
    
    public function __construct() {
        $this->db = new DB();
    }
    
    /**
     * 
     * @return type
     */
    public function getAll() {
        return $this->db->query("SELECT W.id, W.name,W.year,W.subtitle, R.name AS region, S.name AS soil, WT.name AS winetype, "
        . " P.name AS producer, W.grapescoll, W.tasting, W.alcohol, O.name AS oenologiste, W.pricesell, W.photobottle,"
        . " PK.name AS packing, W.obs, W.active "
        . " FROM wine W "
        . " INNER JOIN winetype WT ON WT.id=W.winetype "
        . " INNER JOIN region R ON R.id=W.region "
        . " INNER JOIN soil S ON S.id=W.soil "
        . " INNER JOIN producer P ON P.id=W.producer "
        . " INNER JOIN oenologist O ON O.id=W.oenologist "
        . " INNER JOIN packing PK ON PK.id=W.packing ");
    }
    
    public function getOne($id) {
        return $this->db->query("SELECT W.id, W.name,W.year,W.subtitle, R.name AS region, S.name AS soil, WT.name AS winetype,"
        . " P.name AS producer, W.grapescoll, W.tasting, W.alcohol, O.name AS oenologiste, W.pricesell, W.photobottle,"
        . " PK.name AS packing, W.obs, W.active "
        . " FROM wine W "
        . " INNER JOIN winetype WT ON WT.id=W.winetype "
        . " INNER JOIN region R ON R.id=W.region "
        . " INNER JOIN soil S ON S.id=W.soil "
        . " INNER JOIN producer P ON P.id=W.producer "
        . " INNER JOIN oenologist O ON O.id=W.oenologist "
        . " INNER JOIN packing PK ON PK.id=W.packing "
        . " WHERE W.id=:id ", array(':id'=>$id));
    }
    
    public function search($name) {
        return $this->db->query("SELECT W.id, W.name,W.year,W.subtitle, R.name AS region, S.name AS soil, WT.name AS winetype, "
        . " P.name AS producer, W.grapescoll, W.tasting, W.alcohol, O.name AS oenologiste, W.pricesell, W.photobottle,"
        . " PK.name AS packing, W.obs "
        . " FROM wine W "
        . " INNER JOIN winetype WT ON WT.id=W.winetype "
        . " INNER JOIN region R ON R.id=W.region "
        . " INNER JOIN soil S ON S.id=W.soil "
        . " INNER JOIN producer P ON P.id=W.producer "
        . " INNER JOIN oenologist O ON O.id=W.oenologist "
        . " INNER JOIN packing PK ON PK.id=W.packing "
        . " WHERE W.active=1 AND W.name LIKE :name ", array(':name'=> '%'.$name.'%'));
    }
    
    public function getRandom(){
        //obter o valor do ID mais alto.
        $max = $this->db->query("SELECT max(id) FROM wine");
        $max = intval($max[0][0]);
        //criar um numero aleatorio entre 1 e $max;
        $randNumber = mt_rand(1, $max);
        
        $result = $this->db->query("SELECT W.id, W.name,W.year,W.subtitle, R.name AS region, S.name AS soil, WT.name AS winetype, "
        . " P.name AS producer, W.grapescoll, W.tasting, W.alcohol, O.name AS oenologiste, W.pricesell, W.photobottle,"
        . " PK.name AS packing, W.obs, W.active "
        . " FROM wine W "
        . " INNER JOIN winetype WT ON WT.id=W.winetype "
        . " INNER JOIN region R ON R.id=W.region "
        . " INNER JOIN soil S ON S.id=W.soil "
        . " INNER JOIN producer P ON P.id=W.producer "
        . " INNER JOIN oenologist O ON O.id=W.oenologist "
        . " INNER JOIN packing PK ON PK.id=W.packing "
        . " WHERE W.id=:id ", array(':id'=>$randNumber));
        
        if($result && $result[0]['active']){
            return $result;
        } else {
            $this->getRandom();
        }
    }
}
