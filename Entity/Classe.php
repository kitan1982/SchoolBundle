<?php

namespace Laurent\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Claroline\CoreBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="Laurent\SchoolBundle\Repository\ClasseRepository")
 * @ORM\Table(name="laurent_school_classe")
 */
class Classe
{
    const DEGRE_1 = 1;
    const DEGRE_2 = 2;
    const DEGRE_3 = 3;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column()
     */
    private $code;

    /**
     * @ORM\Column()
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $degre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $annee;

    /**
     * @ORM\OneToOne(targetEntity="Claroline\CoreBundle\Entity\Workspace\Workspace")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    private $Workspace;

    /**
     * @ORM\OneToOne(targetEntity="Claroline\CoreBundle\Entity\Group")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    private $Group;

    /**
     * @var User $eleves
     *
     * @ORM\ManyToMany(
     *     targetEntity="Claroline\CoreBundle\Entity\User",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @ORM\joinTable(name="laurent_school_classe_user")
     */
    private $eleves;

    /**
     * @param mixed $annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

    /**
     * @return mixed
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $degre
     */
    public function setDegre($degre)
    {
        $this->degre = $degre;
    }

    /**
     * @return mixed
     */
    public function getDegre()
    {
        return $this->degre;
    }

    public function getDegreTranslationKey()
    {
        switch ($this->type) {
            case self::DEGRE_1: return "degre1";
            case self::DEGRE_2: return "degre2";
            case self::DEGRE_3: return "degre3";
            default: return "error";
        }
    }

    public function getInputDegre()
    {
        switch ($this->type) {
            case self::DEGRE_1: return "degre1";
            case self::DEGRE_2: return "degre2";
            case self::DEGRE_3: return "degre3";
            default: return "error";
        }
    }


    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $Workspace
     */
    public function setWorkspace($Workspace)
    {
        $this->Workspace = $Workspace;
    }

    /**
     * @return mixed
     */
    public function getWorkspace()
    {
        return $this->Workspace;
    }

    /**
     * @param mixed $Group
     */
    public function setGroup($Group)
    {
        $this->Group = $Group;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->Group;
    }

    /**
     * @param \Laurent\SchoolBundle\Entity\User $eleves
     */
    public function setEleves($eleves)
    {
        $this->eleves = $eleves;
    }

    /**
     * @return \Laurent\SchoolBundle\Entity\User
     */
    public function getEleves()
    {
        return $this->eleves;
    }

    /**
     * @param User $user
     */
    public function addEleves(User $user)
    {
        $this->eleves[] = $user;
    }

}