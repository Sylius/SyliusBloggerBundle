<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Command;

use Sylius\Bundle\BloggerBundle\EventDispatcher\Event\FilterPostEvent;
use Sylius\Bundle\BloggerBundle\EventDispatcher\SyliusBloggerEvents;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

/**
 * Command for console that deletes post.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DeletePostCommand extends ContainerAwareCommand
{
    /**
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('sylius:blogger:post:delete')
            ->setDescription('Deletes a post.')
            ->setDefinition(array(
                new InputArgument('id', InputArgument::REQUIRED, 'The post id'),
            ))
            ->setHelp(<<<EOT
The <info>sylius:blogger:post:delete</info> command deletes a post.

    <info>php sylius/console sylius:blogger:post:delete 24</info>
EOT
            );
    }

    /**
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $post = $this->getContainer()->get('sylius_blogger.manager.post')->findPost($input->getArgument('id'));

        if (!$post) {
            throw new \InvalidArgumentException(sprintf('The post with id "%s" does not exist.', $input->getArgument('id')));
        }

        $this->getContainer()->get('event_dispatcher')->dispatch(SyliusBloggerEvents::POST_DELETE, new FilterPostEvent($post));
        $this->getContainer()->get('sylius_blogger.manipulator.post')->delete($post);

        $output->writeln(sprintf('<info>[Sylius:Blogger]</info> Deleted post with id: <comment>%s</comment>', $input->getArgument('id')));
    }

    /**
     * @see Symfony\Component\Console\Command.Command::interact()
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('id')) {
            $id = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please insert post id: ',
                function($id = null)
                {
                    if (empty($id)) {
                        throw new \Exception('Post id must be specified.');
                    }
                    if (!is_numeric($id)) {
                        throw new \Exception('Post id must be integer.');
                    }
                    return $id;
                }
            );
            $input->setArgument('id', $id);
        }
    }
}
