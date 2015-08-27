<?php

namespace Com\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ComUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
