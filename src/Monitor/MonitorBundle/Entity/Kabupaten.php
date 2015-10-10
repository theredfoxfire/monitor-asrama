<?php

namespace Monitor\MonitorBundle\Entity;

/**
 * Kabupaten
 */
class Kabupaten
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $is_delete;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orang;

    /**
     * @var \Monitor\MonitorBundle\Entity\Provinsi
     */
    private $provinsi;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orang = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Kabupaten
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Kabupaten
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Kabupaten
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
     * @return Kabupaten
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
     * @return Kabupaten
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
     * @return Kabupaten
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
     * Add orang
     *
     * @param \Monitor\MonitorBundle\Entity\Orang $orang
     *
     * @return Kabupaten
     */
    public function addOrang(\Monitor\MonitorBundle\Entity\Orang $orang)
    {
        $this->orang[] = $orang;

        return $this;
    }

    /**
     * Remove orang
     *
     * @param \Monitor\MonitorBundle\Entity\Orang $orang
     */
    public function removeOrang(\Monitor\MonitorBundle\Entity\Orang $orang)
    {
        $this->orang->removeElement($orang);
    }

    /**
     * Get orang
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrang()
    {
        return $this->orang;
    }

    /**
     * Set provinsi
     *
     * @param \Monitor\MonitorBundle\Entity\Provinsi $provinsi
     *
     * @return Kabupaten
     */
    public function setProvinsi(\Monitor\MonitorBundle\Entity\Provinsi $provinsi = null)
    {
        $this->provinsi = $provinsi;

        return $this;
    }

    /**
     * Get provinsi
     *
     * @return \Monitor\MonitorBundle\Entity\Provinsi
     */
    public function getProvinsi()
    {
        return $this->provinsi;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PrePersist
     */
    public function setTokenValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PrePersist
     */
    public function setIsActiveValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PrePersist
     */
    public function setIsDeleteValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
    }
}

