<?php

namespace MiniGame;

class Personnages{
    private int $_id;
    private string $_name;
    private int $_damage = 0;
    private int $_level;
    private int $_xp;

    const MINE = 1;
    const PERSOTUE = 2;
    const PERSOFRAPPE = 3;


    public function __construct(array $data){
        $this->hydrate($data);
    }

    /**
     * @param int $beat_value
     * @return void
     */
    public function addXp(int $beat_value){
            if($beat_value == 2){
                $this->_xp += 5;
            }elseif($beat_value == 3){
                $this->_xp++;
            }
    }

    /**
     * @param array $data
     * @return void
     */
    public function hydrate(array $data){
        foreach ($data as $key=>$value){
            $method = 'set'.ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    /**
     * @param Personnages $perso
     * @return int
     */
    public function beat(Personnages $perso): int
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

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->_level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->_level = $level;
    }

    /**
     * @return int
     */
    public function getXp(): int
    {
        return $this->_xp;
    }

    /**
     * @param int $xp
     */
    public function setXp(int $xp): void
    {
        $this->_xp = $xp;
    }
}
