<?php

namespace Monitor\MonitorBundle\Entity;

/**
 * Provinsi
 */
class Provinsi
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
    private $kabupaten;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kabupaten = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Provinsi
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
     * @return Provinsi
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
     * @return Provinsi
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
     * @return Provinsi
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
     * @return Provinsi
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
     * @return Provinsi
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
     * Add kabupaten
     *
     * @param \Monitor\MonitorBundle\Entity\kabupaten $kabupaten
     *
     * @return Provinsi
     */
    public function addKabupaten(\Monitor\MonitorBundle\Entity\kabupaten $kabupaten)
    {
        $this->kabupaten[] = $kabupaten;

        return $this;
    }

    /**
     * Remove kabupaten
     *
     * @param \Monitor\MonitorBundle\Entity\kabupaten $kabupaten
     */
    public function removeKabupaten(\Monitor\MonitorBundle\Entity\kabupaten $kabupaten)
    {
        $this->kabupaten->removeElement($kabupaten);
    }

    /**
     * Get kabupaten
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKabupaten()
    {
        return $this->kabupaten;
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
    
    public function __toString()
	{
		return $this->getName() ? $this->getName() : "";
	}
}

