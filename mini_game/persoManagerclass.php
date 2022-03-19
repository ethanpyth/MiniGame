<?php

class PersoManager{
    private $_db;

    public function __construct($_db){
        $this->setDb($_db);
    }

    public function delete(Personnage $perso){
        $this->_db->execute('DELETE FROM personnages WHERE id = '. $perso->getId());
    }

    public function update(Personnage $perso){
        $q = $this->_db->prepare('UPDATE personnages SET damages = :damages WHERE id = :id');
        $q->bindValue(':damages', $perso->receiveDamages(), PDO::PARAM_INT);
        $q->bindValue(':damages', $perso->getId(), PDO::PARAM_INT);
        $q->execute();
    }

    public function add(Personnage $perso){
        $q = $this->_db->prepare('INSERT INTO personnages SET name = :name');
        $q->bindValue(':name', $perso->getName());
        $q->execute();

        $perso->hydrate(
            array(
                'id' => $this->_db->lastInsertId(),
                'damages' => 0
            )
        );
    }

    public function count(){
        return $this->_db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
    }

    public function exists($info){
        if(is_int($info)){
            return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
        }

        $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE name = :name');
        $q->execute(array(':name' => $info));

        return (bool) $q->fetchColumn();
    }

    public function getInfo($info){
        if(is_int($info)){
            $q = $this->_db->query('SELECT id, name, damges FROM personnages WHERE id = '.$info);
            $data = $q->fetch(PDO::FETCH_ASSOC);

            return new Personnage($data);
        }else{
            $q = $this->_db->prepare('SELECT id , name, damages FROM personnages WHERE name = :name');
            $q->execute(array(':name' => $info));

            return new Personnage($q->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList(Personnage $name){
        $persos = array();

        $q = $this->_db->prepare('SELECT id, name, damages FROM personnages WHERE name <> :name ORDER BY name');
        $q->execute(array(':name' => $name));

        while($data = $q->fetch(PDO::FETCH_ASSOC)){
            $persos[] = new Personnage($data);
        }

        return $persos;
    }

    /**
     * @param mixed $db
     */
    public function setDb(PDO $db): void
    {
        $this->_db = $db;
    }
}
