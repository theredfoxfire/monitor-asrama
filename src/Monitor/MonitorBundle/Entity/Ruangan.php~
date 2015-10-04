<?php

namespace Monitor\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ruangan
 */
class Ruangan
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nama;

    /**
     * @var boolean
     */
    private $is_active;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \Monitor\MonitorBundle\Entity\Asrama
     */
    private $asrama;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $penghuni;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->penghuni = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Ruangan
     */
    public function setNama($nama)
    {
        $this->nama = $nama;

        return $this;
    }

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Ruangan
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ruangan
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Ruangan
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Ruangan
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set asrama
     *
     * @param \Monitor\MonitorBundle\Entity\Asrama $asrama
     *
     * @return Ruangan
     */
    public function setAsrama(\Monitor\MonitorBundle\Entity\Asrama $asrama = null)
    {
        $this->asrama = $asrama;

        return $this;
    }

    /**
     * Get asrama
     *
     * @return \Monitor\MonitorBundle\Entity\Asrama
     */
    public function getAsrama()
    {
        return $this->asrama;
    }

    /**
     * Add penghuni
     *
     * @param \Monitor\MonitorBundle\Entity\Penghuni $penghuni
     *
     * @return Ruangan
     */
    public function addPenghuni(\Monitor\MonitorBundle\Entity\Penghuni $penghuni)
    {
        $this->penghuni[] = $penghuni;

        return $this;
    }

    /**
     * Remove penghuni
     *
     * @param \Monitor\MonitorBundle\Entity\Penghuni $penghuni
     */
    public function removePenghuni(\Monitor\MonitorBundle\Entity\Penghuni $penghuni)
    {
        $this->penghuni->removeElement($penghuni);
    }

    /**
     * Get penghuni
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPenghuni()
    {
        return $this->penghuni;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->created_at = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function setTokenValue()
    {
        if(!$this->getToken()) {
            $st = date('Y-m-d H:i:s');
			$this->token = sha1($st.rand(11111, 99999));
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function setIsActiveValue()
    {
        $this->is_active = true;
    }
}
