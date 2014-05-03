<?php

namespace Vep\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VepUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}
