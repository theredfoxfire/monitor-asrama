<?php

namespace Monitor\MonitorBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
/**
 * Penghuni
 */
class Penghuni
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $tanggal;

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
     * @var \Monitor\MonitorBundle\Entity\Ruangan
     */
    private $ruangan;

    /**
     * @var \Monitor\MonitorBundle\Entity\Orang
     */
    private $orang;


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
     * Set tanggal
     *
     * @param \DateTime $tanggal
     *
     * @return Penghuni
     */
    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;

        return $this;
    }

    /**
     * Get tanggal
     *
     * @return \DateTime
     */
    public function getTanggal()
    {
        return $this->tanggal;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Penghuni
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
     * @return Penghuni
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
     * @return Penghuni
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
     * @return Penghuni
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
     * Set ruangan
     *
     * @param \Monitor\MonitorBundle\Entity\Ruangan $ruangan
     *
     * @return Penghuni
     */
    public function setRuangan(\Monitor\MonitorBundle\Entity\Ruangan $ruangan = null)
    {
        $this->ruangan = $ruangan;

        return $this;
    }

    /**
     * Get ruangan
     *
     * @return \Monitor\MonitorBundle\Entity\Ruangan
     */
    public function getRuangan()
    {
        return $this->ruangan;
    }

    /**
     * Set orang
     *
     * @param \Monitor\MonitorBundle\Entity\Orang $orang
     *
     * @return Penghuni
     */
    public function setOrang(\Monitor\MonitorBundle\Entity\Orang $orang = null)
    {
        $this->orang = $orang;

        return $this;
    }

    /**
     * Get orang
     *
     * @return \Monitor\MonitorBundle\Entity\Orang
     */
    public function getOrang()
    {
        return $this->orang;
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
}
