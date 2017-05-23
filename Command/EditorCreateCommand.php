<?php

/*
 * This file is a part of Sculpin.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mavimo\Sculpin\Bundle\EditorBundle\Command;

use Sculpin\Core\Console\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Sculpin Editor Bundle.
 *
 * @author Marco Vito Moscaritolo <marco@mavimo.org>
 */
class EditorCreateCommand extends ContainerAwareCommand
{
    private $title;
    private $date;
    private $type;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('editor:create')
            ->setDescription('Create a new content.')
            ->setHelp("The <info>editor:create</info> command create a new post content.")
            ->addOption('type', 't', InputOption::VALUE_REQUIRED, 'Type of content to create', 'post')
            ->addOption('date', 'd', InputOption::VALUE_REQUIRED, 'Date of content to create', date('Y-m-d'))
            ->addArgument('title', InputArgument::REQUIRED);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->type = $input->getOption('type');
        $this->date = \DateTime::createFromFormat('Y-m-d', $input->getOption('date'));
        $this->title = $input->getArgument('title');

        $filesystem = new Filesystem();

        $filesystem->dumpFile(
            $this->createPath(),
            $this->createContent()
        );

        $output->writeln("Created file: " . $this->createPath());
    }

    /**
     * Path where save file.
     *
     * @return string
     *   Generated path.
     */
    protected function createPath()
    {
        return "source/_" . $this->type . "s/". $this->date->format('Y-m-d') . "-" . $this->normalizeTitle($this->title) . '.md';
    }

    /**
     * Content for the current item.
     *
     * @return string
     *   Content
     */
    protected function createContent()
    {
        $content = <<<EOL
---
title: {$this->title}
draft: true
---
EOL;
        return $content;
    }

    /**
     * Generate title for the content.
     *
     * @param string $title
     *   Title to clean.
     *
     * @return string
     *   Normalized title
     */
    protected function normalizeTitle($title)
    {
        // Get Current Locale
        $currentLocale = setlocale(LC_ALL, 0);
        // Change to UTF-8 Locale
        setlocale(LC_ALL, 'en_US.utf8');
        // Lowercase
        $title_clean = strtolower($title);
        // Remove Accents by converting UTF-8 to ASCII
        $title_clean = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title_clean);
        // Replace space and non alphanumeric with dash
        $title_clean = preg_replace("/[^a-z0-9]+/", "-", $title_clean);
        // Restore locale to default value
        setlocale(LC_ALL, $currentLocale);
        return $title_clean;
    }
}
