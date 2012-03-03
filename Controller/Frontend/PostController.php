<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Controller\Frontend;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Post controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PostController extends ContainerAware
{
    /**
     * Shows single post.
     */
    public function showAction($slug, $id)
    {
        $post = $this->container->get('sylius_blogger.manager.post')->findPostBy(array('slug' => $slug, 'id' => $id));

        if (!$post || !$post->isPublished()) {
            throw new NotFoundHttpException('Requested post does not exist.');
        }

        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Frontend/Post:show.html.' . $this->getEngine(), array(
            'post' => $post
        ));
    }

    /**
     * Lists paginated posts.
     */
    public function listAction()
    {
        $postManager = $this->container->get('sylius_blogger.manager.post');

        if ($this->container->getParameter('sylius_blogger.pagination')) {
            $paginator = $postManager->createPaginator();
            $paginator->setCurrentPage($this->container->get('request')->query->get('page', 1), true, true);
            $paginator->setMaxPerPage($this->container->getParameter('sylius_blogger.pagination.mpp'));

            $parameters['paginator'] = $paginator;

            $posts = $paginator->getCurrentPageResults();
        } else {
            $posts = $postManager->findPosts();
        }

        $parameters['posts'] = $posts;

        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Frontend/Post:list.html.' . $this->getEngine(), $parameters);
    }

    /**
    * Returns templating engine name.
    *
    * @return string
    */
    protected function getEngine()
    {
        return $this->container->getParameter('sylius_blogger.engine');
    }
}
