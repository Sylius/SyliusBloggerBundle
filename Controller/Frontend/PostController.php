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
    	
    	if (!$post) {
    	    throw new NotFoundHttpException('Requested post does not exist.');
    	}	
        
        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Frontend/Post:show.html.twig', array(
        	'post' => $post
        ));
    }
    
	/**
     * Lists paginated posts.
     */
    public function listAction($page = 1)
    {
        $postManager = $this->container->get('sylius_blogger.manager.post');
        $paginator = $postManager->createPaginator();
        
        $paginator->setCurrentPage($page, true, true);
        
        $posts = $paginator->getCurrentPageResults();
        
        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Frontend/Post:list.html.twig', array(
        	'posts' => $posts,
        	'paginator' => $paginator
        ));
    }
}
