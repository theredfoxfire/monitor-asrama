<?php

namespace Monitor\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orang
 */
class Orang
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
     * @var string
     */
    private $no_identitas;

    /**
     * @var string
     */
    private $jk;

    /**
     * @var string
     */
    private $alamat;

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
     * @return Orang
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
     * Set noIdentitas
     *
     * @param string $noIdentitas
     *
     * @return Orang
     */
    public function setNoIdentitas($noIdentitas)
    {
        $this->no_identitas = $noIdentitas;

        return $this;
    }

    /**
     * Get noIdentitas
     *
     * @return string
     */
    public function getNoIdentitas()
    {
        return $this->no_identitas;
    }

    /**
     * Set jk
     *
     * @param string $jk
     *
     * @return Orang
     */
    public function setJk($jk)
    {
        $this->jk = $jk;

        return $this;
    }

    /**
     * Get jk
     *
     * @return string
     */
    public function getJk()
    {
        return $this->jk;
    }

    /**
     * Set alamat
     *
     * @param string $alamat
     *
     * @return Orang
     */
    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;

        return $this;
    }

    /**
     * Get alamat
     *
     * @return string
     */
    public function getAlamat()
    {
        return $this->alamat;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Orang
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
     * @return Orang
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
     * @return Orang
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
     * @return Orang
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
     * Add penghuni
     *
     * @param \Monitor\MonitorBundle\Entity\Penghuni $penghuni
     *
     * @return Orang
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
     * @var boolean
     */
    private $is_delete;


    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Orang
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
     * @ORM\PrePersist
     */
    public function setIsActiveValue()
    {
        $this->is_active = true;
    }

    /**
     * @ORM\PrePersist
     */
    public function setIsDeleteValue()
    {
        $this->is_delete = false;
    }
    /**
     * @var \Monitor\MonitorBundle\Entity\Kabupaten
     */
    private $kabupaten;


    /**
     * Set kabupaten
     *
     * @param \Monitor\MonitorBundle\Entity\Kabupaten $kabupaten
     *
     * @return Orang
     */
    public function setKabupaten(\Monitor\MonitorBundle\Entity\Kabupaten $kabupaten = null)
    {
        $this->kabupaten = $kabupaten;

        return $this;
    }

    /**
     * Get kabupaten
     *
     * @return \Monitor\MonitorBundle\Entity\Kabupaten
     */
    public function getKabupaten()
    {
        return $this->kabupaten;
    }
}
