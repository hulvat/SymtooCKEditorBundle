<?php

namespace Symtoo\CKEditorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Component\Finder\Finder;

class InstallCKEditorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('ckeditor:install')
            ->setDescription('Installs CKEditor javascripts from the latest stable SVN.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();
        $finder = new Finder();
        $publicDir = dirname(__FILE__).'/../Resources/public';
        $stableUrl = 'http://svn.ckeditor.com/CKEditor/releases/stable/';
        $workingCopy = $publicDir.'/ckeditor-latest-stable';
        
        $files = array(
            'ckeditor.js',
            'ckeditor_basic.js',
            'config.js',
            'LICENSE.html',
            'contents.css',
            'adapters',
            'images',
            'lang',
            'plugins',
            'skins',
            'themes',
        );

        $fs->remove($workingCopy);
        $output->writeln('Exporting CKEditor from SVN');
        svn_export($stableUrl, $workingCopy, false);
        
        foreach ($files as $file) {
            $output->writeln('copying the '.$file);
            $fs->remove($publicDir.'/'.$file);
            if (is_dir($workingCopy.'/'.$file)) {
                $fs->mirror($workingCopy.'/'.$file, $publicDir.'/'.$file);
            } else {
                $fs->copy($workingCopy.'/'.$file, $publicDir.'/'.$file, true);
            }
            $fs->remove($workingCopy.'/'.$file);
        }
        $fs->remove($workingCopy);
    }
}