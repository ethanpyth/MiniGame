<?php

namespace MiniGame;

use PDO;
use MiniGame\Personnages;

class PersoManager{
    private mixed $_db;

    public function __construct($db){
        $this->setDb($db);
    }

    public function delete(Personnages $perso){
        $this->_db->execute('DELETE FROM personnages WHERE id = '. $perso->getId());
    }

    public function update(Personnages $perso, string $field_db){
        $method = 'increase'. ucfirst($field_db);
        $q = $this->_db->prepare('UPDATE personnages SET ' . $field_db .' = :field_db WHERE id = :id');
        $q->bindValue(':field_db', $perso->$method(), PDO::PARAM_INT);
        $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        $q->execute();
    }

    public function add(Personnages $perso){
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

    public function exists($info): bool
    {
        if(is_int($info)){
            return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
        }

        $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE name = :name');
        $q->execute(array(':name' => $info));

        return (bool) $q->fetchColumn();
    }

    public function getInfo($info): Personnages
    {
        if(is_int($info)){
            $q = $this->_db->query('SELECT id, name, damages, xp, level, strength FROM personnages WHERE id = ' . $info);
            $data = $q->fetch(PDO::FETCH_ASSOC);

            return new Personnages($data);
        }else{
            $q = $this->_db->prepare('SELECT id , name, damages, xp, level, strength FROM personnages WHERE name = :name');
            $q->execute(array(':name' => $info));

            return new Personnages($q->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($name): array
    {
        $persos = array();

        $q = $this->_db->prepare('SELECT id, name, damages FROM personnages WHERE name <> :name ORDER BY name');
        $q->execute(array(':name' => $name));

        while($data = $q->fetch(PDO::FETCH_ASSOC)){
            $persos[] = new Personnages($data);
        }

        return $persos;
    }

    /**
     * @param mixed $db
     */
    public function setDb(mixed $db): void
    {
        $this->_db = $db;
    }
}
