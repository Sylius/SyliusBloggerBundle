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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Bundle\BloggerBundle\Model\PostInterface;
use Sylius\Bundle\BloggerBundle\Model\PostManager as BasePostManager;
use Sylius\Bundle\BloggerBundle\Sorting\SorterInterface;

/**
 * Post manager.
 * Doctrine ORM driver implementation.
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
     * @param EntityManager $entityManager
     * @param string        $class
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
    public function createPaginator(SorterInterface $sorter = null, $filterNotPublished = true)
    {
        $queryBuilder = $this->repository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
        ;

        if ($filterNotPublished) {
            $queryBuilder->andWhere('p.published = true');
        } else {
            $queryBuilder->andWhere('p.published = false');
        }

        if (null !== $sorter) {
            $sorter->sort($queryBuilder);
        }

        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder->getQuery()));
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
}
