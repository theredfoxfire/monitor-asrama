<?php

namespace Monitor\MonitorBundle\Repository;

/**
 * AsramaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AsramaRepository extends \Doctrine\ORM\EntityRepository
{
	public function getAsrama()
	{
		$query = $this->getEntityManager()
			->createQuery('
				SELECT a FROM MonitorMonitorBundle:Asrama a
				where a.is_delete = :is 
				ORDER BY a.created_at ASC
			')->setParameters(array(
				'is' => false
			));
		return $query;
	}
}
