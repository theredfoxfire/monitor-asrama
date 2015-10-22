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
<<<<<<< HEAD
    private $tanggal_1;
    /**
     * @var \DateTime
     */
    private $tanggal_2;
=======
    private $tanggal;

>>>>>>> 57281c5fc2706fd9fc5fbcd2c510a9372adf3149
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
<<<<<<< HEAD
    public function getTanggal1()
    {
        return $this->tanggal_1;
    }
    /**
     * Set createdAt
     *
     * @param \DateTime $tanggal
     *
     * @return Report
     */
    public function setTanggal1($tanggal_1)
    {
        $this->tanggal_1 = $tanggal_1;
        return $this;
    }
        /**
     * Get tanggal
     *
     * @return DateTime
     */
    public function getTanggal2()
=======
    public function getTanggal()
>>>>>>> 57281c5fc2706fd9fc5fbcd2c510a9372adf3149
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
<<<<<<< HEAD
        $this->tanggal_2 = $tanggal_2;
=======
        $this->tanggal = $tanggal;

>>>>>>> 57281c5fc2706fd9fc5fbcd2c510a9372adf3149
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
