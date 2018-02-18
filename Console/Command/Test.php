<?php

namespace Grayson\Post\Console\Command;

use Grayson\Post\Model\Post;
use Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Test
 * @package Grayson\Post\Console\Command
 */
class Test extends Command
{

    protected function configure()
    {
        $this->setName('Grayson:post-test')
            ->setDescription('test');

        return parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        $objectManagement = ObjectManager::getInstance();

        $post = $objectManagement->create(Post::class);

        $post->addData(
            [
                'name' => 'asdfadf'
            ]
        )->save();


        return $this;
    }


}
