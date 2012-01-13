<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Entity;

use Sylius\Bundle\BloggerBundle\Model\PostInterface;
use Sylius\Bundle\BloggerBundle\Model\PostManager as BasePostManager;
use Sylius\Bundle\BloggerBundle\Sorting\SorterInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * Post manager.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PostManager extends BasePostManager
{
    /**
     * Entity manager.
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Entity repository.
     *
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param EntityManager	 $entityManager
     * @param string	 	 $class
     */
    public function __construct(EntityManager $entityManager, $class)
    {
        parent::__construct($class);

        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository($this->getClass());
    }

    /**
     * {@inheritdoc}
     */
    public function createPost()
    {
        $class = $this->getClass();
        return new $class;
    }

    /**
     * {@inheritdoc}
     */
    public function persistPost(PostInterface $post)
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function removePost(PostInterface $post)
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function findPost($id)
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findPostBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findPosts()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findPostsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function createPaginator(SorterInterface $sorter = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from($this->class, 'p')
            ->where('p.published = true')
            ->orderBy('p.createdAt', 'DESC');

        if (null !== $sorter) {
            $sorter->sort($queryBuilder);
        }

        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder->getQuery()));
    }
}
