<?php namespace App;

class TypeModifierCalculator {
    private $playerAttack;
    private $againstPokemon;

    private $multipliers = [
        [1,1,1,1,1,1,1,1,1,1,1,1,0.5,0,1,1,0.5,0],
        [1,0.5,0.5,1,2,2,1,1,1,1,1,2,0.5,1,0.5,1,2,1],
        [1,2,0.5,1,0.5,1,1,1,2,1,1,1,2,1,0.5,1,1,1],
        [1,1,2,0.5,0.5,1,1,1,0,2,1,1,1,1,0.5,1,1,1],
        [1,0.5,2,1,0.5,1,1,0.5,2,0.5,1,0.5,2,1,0.5,1,0.5,1],
        [1,0.5,0.5,1,2,0.5,1,1,2,2,1,1,1,1,2,1,0.5,1],
        [2,1,1,1,1,2,1,0.5,1,0.5,0.5,0.5,2,0,1,2,2,0.5],
        [1,1,1,1,2,1,1,0.5,0.5,1,1,1,0.5,0.5,1,1,0,2],
        [1,2,1,2,0.5,1,1,2,1,0,1,0.5,2,1,1,1,2,1],
        [1,1,1,0.5,2,1,2,1,1,1,1,2,0.5,1,1,1,0.5,1],
        [1,1,1,1,1,1,2,2,1,1,0.5,1,1,1,1,0,0.5,1],
        [1,0.5,1,1,2,1,0.5,0.5,1,0.5,2,1,1,0.5,1,2,0.5,0.5],
        [1,2,1,1,1,2,0.5,1,0.5,2,1,2,1,1,1,1,0.5,1],
        [0,1,1,1,1,1,1,1,1,1,2,1,1,2,1,0.5,1,1],
        [1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,1,0.5,0],
        [1,1,1,1,1,1,0.5,1,1,1,2,1,1,2,1,0.5,1,0.5],
        [1,0.5,0.5,0.5,1,2,1,1,1,1,1,1,2,1,1,1,0.5,2],
        [1,0.5,1,1,1,1,2,0.5,1,1,1,1,1,1,2,2,0.5,1]
    ];

    public function __construct(Attack $playerAttack, Pokemon $against)
    {
        $this->playerAttack = $playerAttack;
        $this->againstPokemon = $against;
    }

    public function calculate()
    {
        $accuracy = rand(1, 100);
        $typeModifier = $this->calculateTypeModifier($this->playerAttack);

        if ($accuracy >= 90) {
            $typeModifier->defineCritical();
        }

        if ($accuracy <= 10) {
            $typeModifier->defineMissed();
        }

        return $typeModifier;
    }

    public function calculateTypeModifier(Attack $playerAttack)
    {
        $defense = AttackType::getValue($this->againstPokemon->getType());
        $attack = AttackType::getValue($playerAttack->getType());
        $multiplier = $this->multipliers[$attack][$defense];

        if ($multiplier > 0) {
            if ($multiplier == 1)
                return new TypeModifier(DamageType::NORMAL);

            if ($multiplier > 1)
                return new TypeModifier(DamageType::DOUBLE_DAMAGE);

            if ($multiplier < 1)
                return new TypeModifier(DamageType::HALF_DAMAGE);
        }

        return new TypeModifier(DamageType::NO_DAMAGE);

    }
    
    public function calculateTypeModifier(Attack $playerAttack)
    {
        $defense = AttackType::getValue($this->againstPokemon->getType());
        $attack = AttackType::getValue($playerAttack->getType());
        $multiplier = $this->multipliers[$attack][$defense];
        if ($multiplier > 0) {
            if ($multiplier == 1)
                return new TypeModifier(DamageType::NORMAL);
            if ($multiplier > 1)
                return new TypeModifier(DamageType::DOUBLE_DAMAGE);
            if ($multiplier < 1)
                return new TypeModifier(DamageType::HALF_DAMAGE);
        }
        return new TypeModifier(DamageType::NO_DAMAGE);
    }
}
