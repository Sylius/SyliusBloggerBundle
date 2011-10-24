<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Controller\Backend;

use Sylius\Bundle\BloggerBundle\EventDispatcher\Event\FilterPostEvent;
use Sylius\Bundle\BloggerBundle\EventDispatcher\SyliusBloggerEvents;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Post backend controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PostController extends ContainerAware
{
    /**
     * Display table of posts.
     */
    public function listAction()
    {
    	$posts = $this->container->get('sylius_blogger.manager.post')->findPosts();

        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Backend/Post:list.html.twig', array(
        	'posts' => $posts
        ));
    }
    
    /**
     * Shows a post.
     */
    public function showAction($id)
    {
        $post = $this->container->get('sylius_blogger.manager.post')->findPost($id);
        
        if (!$post) {
            throw new NotFoundHttpException('Requested product does not exist.');
        }
        
        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Backend/Post:show.html.twig', array(
        	'post' => $post
        ));
    }
    
	/**
     * Creating a new post.
     */
    public function createAction()
    {
        $request = $this->container->get('request');
        
        $post = $this->container->get('sylius_blogger.manager.post')->createPost();
        
        $form = $this->container->get('form.factory')->create($this->container->get('sylius_blogger.form.type.post'));
        $form->setData($post);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusBloggerEvents::POST_CREATE, new FilterPostEvent($post));
                $this->container->get('sylius_blogger.manipulator.post')->create($post);
               
                return new RedirectResponse($this->container->get('router')->generate('sylius_blogger_backend_post_list'));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Backend/Post:create.html.twig', array(
        	'form' => $form->createView()
        ));
    }
    
    /**
     * Updating a post..
     */
    public function updateAction($id)
    {
        
        $post = $this->container->get('sylius_blogger.manager.post')->findPost($id);
        
        if (!$post) {
            throw new NotFoundHttpException('Requested post does not exist.');
        }
        
        $request = $this->container->get('request');
        
        $form = $this->container->get('form.factory')->create($this->container->get('sylius_blogger.form.type.post'));
        $form->setData($post);
        
        if ('POST' == $request->getMethod()) {        
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusBloggerEvents::POST_UPDATE, new FilterPostEvent($post));
                $this->container->get('sylius_blogger.manipulator.post')->update($post);
                
                return new RedirectResponse($this->container->get('router')->generate('sylius_blogger_backend_post_list'));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusBloggerBundle:Backend/Post:update.html.twig', array(
        	'form' => $form->createView(),
            'post' => $post
        ));
    }
    
	/**
     * Deletes post.
     */
    public function deleteAction($id)
    {
        $post = $this->container->get('sylius_blogger.manager.post')->findPost($id);
        
        if (!$post) {
            throw new NotFoundHttpException('Requested post does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusBloggerEvents::POST_DELETE, new FilterPostEvent($post));
        $this->container->get('sylius_blogger.manipulator.post')->delete($post);
        
        return new RedirectResponse($this->container->get('router')->generate('sylius_blogger_backend_post_list'));
    }
}
