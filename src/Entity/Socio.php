<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocioRepository::class)
 */
class Socio implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nomeSocio;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $cpf;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $posicao;

    /**
     * @ORM\ManyToOne(targetEntity=Empresa::class, inversedBy="socios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $empresa;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeSocio(): ?string
    {
        return $this->nomeSocio;
    }

    public function setNomeSocio(string $nomeSocio): self
    {
        $this->nomeSocio = $nomeSocio;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getPosicao(): ?string
    {
        return $this->posicao;
    }

    public function setPosicao(string $posicao): self
    {
        $this->posicao = $posicao;

        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNomeSocio(),
            'cpf' => $this->getCpf(),
            'posicao' => $this->getPosicao(),
            'empresa' => $this->getEmpresa()
        ];
    }
}
