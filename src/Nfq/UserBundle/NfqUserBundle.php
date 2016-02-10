<?php

namespace Nfq\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NfqUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
