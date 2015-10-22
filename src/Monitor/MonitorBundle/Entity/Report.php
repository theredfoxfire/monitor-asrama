<?php

namespace Monitor\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * User
 */
class Report
{
    /**
     * @var \DateTime
     */
    private $tanggal;

    /**
     * @var integer
     */
    private $kabupaten;

    /**
     * @var integer
     */
    private $angkatan;

    /**
     * @var integer
     */
    private $asrama;
    
    /**
     * @var string
     */
    private $jk;


    /**
     * Get tanggal
     *
     * @return DateTime
     */
    public function getTanggal()
    {
        return $this->tanggal;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $tanggal
     *
     * @return Report
     */
    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;

        return $this;
    }

    /**
    * @Get kabupaten
    * @return integer
    */
    public function getKabupaten()
    {
        return $this->kabupaten;
    }

    /**
    * @param $kabupaten 
    * @return Report
    */
    public function setKabupaten($kabupaten)
    {
        $this->kabupaten = $kabupaten;
        return;
    }

    /**
    * Get angkatan
    * @return integer
    */
    public function getAngkatan()
    {
        return $this->angkatan;
    }

    /**
    * Set angkatan
    * @param $angkatan Integer
    * @return Report
    */
    public function setAngkatan($angkatan)
    {
        $this->angkatan = $angkatan;

        return;
    }

    /**
    * Get asrama
    * @return integer
    */
    public function getAsrama()
    {
        return $this->asrama;
    }

    /**
    * Set asrama
    * @param $asrama integer
    */
    public function setAsrama($asrama)
    {
        $this->asrama = $asrama;

        return;
    }

    /**
    * Get jk
    * @return string
    */
    public function getJk()
    {
        return $this->jk;
    }

    /**
    * Set jk
    * @param $jk
    * @return Report
    */
    public function setJk($jk)
    {
        $this->jk = $jk;

        return;
    }
}
