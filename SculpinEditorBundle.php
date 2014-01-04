<?php

/*
 * This file is a part of Sculpin.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mavimo\Sculpin\Bundle\EditorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;
use Mavimo\Sculpin\Bundle\EditorBundle\Command\EditorCreateCommand;

/**
 * Sculpin Editor Bundle.
 *
 * @author Marco Vito Moscaritolo <marco@mavimo.org>
 */
class SculpinEditorBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        $application->add(new EditorCreateCommand(''));
    }
}
