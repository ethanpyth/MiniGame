<?php

namespace MiniGame;

class Personnages{
    private int $_id;
    private string $_name;
    private int $_damage = 0;
    private int $_level;
    private int $_xp;
    private int $_strength;

    const MINE = 1;
    const PERSOTUE = 2;
    const PERSOFRAPPE = 3;

    /**
     * @param array $data
     */
    public function __construct(array $data){
        $this->hydrate($data);
    }

    public function increaseStrength(){
        $this->_strength += 3;
    }

    public function increaseLevel(int $xp){
        if ($xp % 10 == 0){
            $this->_level++;
        }
    }

    /**
     * @param int $beat_value
     * @return void
     */
    public function increaseXp(int $beat_value){
        if($this->getXp())
            if($beat_value == 2){
                $this->_xp += 5;
            }elseif($beat_value == 3){
                $this->_xp += 3;
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
            return $perso->increaseDamages();
        }else{
            return self::MINE;
        }
    }

    public function validName(): bool
    {
        return !empty($this->_name);
    }

    public  function increaseDamages(): string
    {
        $this->_damage += 5;

        if($this->_damage >= 100){
            return self::PERSOTUE;
        }else{
            return self::PERSOFRAPPE;
        }
    }

    public function decreaseDamages(){
        if ( $this->_damage >= 0 && $this->_damage <=100 ){
            $this->_damage -= 2;
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

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->_strength;
    }

    /**
     * @param int $strength
     */
    public function setStrength(int $strength): void
    {
        $this->_strength = $strength;
    }
}
