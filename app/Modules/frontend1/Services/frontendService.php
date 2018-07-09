<?php

namespace App\Modules\frontend1\Services;

use Illuminate\Contracts\Container\Container;
use App\Core\Service;
use App\Modules\frontend1\Repositories\frontend1Repository;

class frontend1Service extends Service
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, frontend1Repository $repo)
    {
        parent::__construct($app, $repo);
    }
}
