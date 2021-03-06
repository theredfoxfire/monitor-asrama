<?php

namespace Monitor\MonitorBundle\Repository;

/**
 * PenghuniRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PenghuniRepository extends \Doctrine\ORM\EntityRepository
{
	public function getPenghuni($idru)
	{
		$query = $this->getEntityManager()
			->createQuery('
				select p from MonitorMonitorBundle:Penghuni p 
				inner join p.orang o
				inner join p.ruangan r
				where r.id = :idru and p.is_delete = :is
				order by p.created_at asc
			')->setParameters(array(
				'idru' => $idru,
				'is' => false
			));
		
		return $query->getResult();
	}
	
	public function getPenghuniQuery($idru)
	{
		$query = $this->getEntityManager()
			->createQuery('
				select p from MonitorMonitorBundle:Penghuni p
				inner join p.orang o
				inner join p.ruangan r
				where r.id = :idru and p.is_delete = :is
				order by p.created_at asc
			')->setParameters(array(
				'idru' => $idru,
				'is' => false
			));
		
		return $query;
	}
	public function getReportQuery($data)
	{
		$query = $this->getEntityManager()
			->createQueryBuilder()
			->from('Monitor\MonitorBundle\Entity\Penghuni', 'p')
			->select('p', 'o', 'r', 'a')
			->innerJoin('p.orang', 'o')
			->innerJoin('p.ruangan', 'r')
			->innerJoin('r.asrama', 'a')
			->where('p.is_delete = :del')
			->setParameter('del', false);
		if (!empty($data['tgl1'])) {
			$query->andWhere('p.tanggal between :tgl1 and :tgl2')
			->setParameter('tgl1', new \DateTime($data['tgl1']))
			->setParameter('tgl2', new \DateTime($data['tgl2']));
		}
		if (!empty($data['kabupaten'])) {
			$query->andWhere('o.kabupaten = :kab')
			->setParameter('kab', $data['kabupaten']);
		}
		if (!empty($data['asrama'])) {
			$query->andWhere('r.asrama = :asr')
			->setParameter('asr', $data['asrama']);
		}
		if (!empty($data['jk'])) {
			$query->andWhere('o.jk = :jk')
			->setParameter('jk', $data['jk']);
		}
		if (!empty($data['angkatan'])) {
			$query->andWhere(' substring(o.no_identitas,1,2) = :ang')
			->setParameter('ang', substr($data['angkatan'], 2,2));
		}

		$query->orderBy('p.tanggal', 'ASC');

		return $query->getQuery();

	}

	public function getReportData($data)
	{
		$query = $this->getEntityManager()
			->createQueryBuilder()
			->from('Monitor\MonitorBundle\Entity\Penghuni', 'p')
			->select('p', 'o', 'r', 'a')
			->innerJoin('p.orang', 'o')
			->innerJoin('p.ruangan', 'r')
			->innerJoin('r.asrama', 'a')
			->where('p.is_delete = :del')
			->setParameter('del', false);
		if (!empty($data['tgl1'])) {
			$query->andWhere('p.tanggal between :tgl1 and :tgl2')
			->setParameter('tgl1', new \DateTime($data['tgl1']))
			->setParameter('tgl2', new \DateTime($data['tgl2']));
		}
		if (!empty($data['kabupaten'])) {
			$query->andWhere('o.kabupaten = :kab')
			->setParameter('kab', $data['kabupaten']);
		}
		if (!empty($data['asrama'])) {
			$query->andWhere('r.asrama = :asr')
			->setParameter('asr', $data['asrama']);
		}
		if (!empty($data['jk'])) {
			$query->andWhere('o.jk = :jk')
			->setParameter('jk', $data['jk']);
		}
		if (!empty($data['angkatan'])) {
			$query->andWhere(' substring(o.no_identitas,1,2) = :ang')
			->setParameter('ang', substr($data['angkatan'], 2,2));
		}

		$query->orderBy('p.tanggal', 'ASC');
		return $query->getQuery()->getResult();

	}
}
