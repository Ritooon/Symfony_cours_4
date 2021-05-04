<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class RechercheVoiture {
    /**
     * @Assert\LessThanOrEqual(propertyPath="maxAnnee", message="Doit être inférieur à l'année de fin")
     */
    private $minAnnee;
    /**
     * @Assert\GreaterThanOrEqual(propertyPath="minAnnee", message="Doit être supérieur à l'année de début")
     */
    private $maxAnnee;

    public function getMinAnnee() {
        return $this->minAnnee;
    }

    public function getMaxAnnee() {
        return $this->maxAnnee;
    }

    public function setMinAnnee(int $minAnnee) {
        $this->minAnnee = $minAnnee;
        return $this;
    }

    public function setMaxAnnee(int $maxAnnee) {
        $this->maxAnnee = $maxAnnee;
        return $this;
    }
}