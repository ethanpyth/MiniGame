<?php

namespace MiniGame;

class Personnages{
    private int $_id;
    private string $_name;
    private int $_damage;

    const MINE = 1;
    const PERSOTUE = 2;
    const PERSOFRAPPE = 3;


    public function __construct(array $data){
        $this->hydrate($data);
    }

    public function hydrate(array $data){
        $key = "";
        $value = "";
        foreach ($data as $key->$value){
            $method = 'set'.ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    public function beat(Personnages $perso): int|string
    {
        if($perso->_id != $this->_id){
            return $perso->receiveDamages();
        }else{
            return self::MINE;
        }
    }

    public function validName(): bool
    {
        return !empty($this->_name);
    }

    public  function receiveDamages(): string
    {
        $this->setDamage(5);

        if($this->_damage >= 100){
            return self::PERSOTUE;
        }else{
            return self::PERSOFRAPPE;
        }
    }

    /**
     * @return int
     */
    public function getDamage(): int
    {
        return $this->_damage;
    }

    /**
     * @param int $damage
     */
    public function setDamage(int $damage): void
    {
        if($damage >= 0 && $damage <= 100){
            $this->_damage = $damage;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->_name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        if($id > 0){
            $this->_id = $id;
        }
    }
}
