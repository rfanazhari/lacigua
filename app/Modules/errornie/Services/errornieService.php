<?php

namespace App\Modules\errornie\Services;

use Illuminate\Contracts\Container\Container;
use App\Core\Service;
use App\Modules\errornie\Repositories\errornieRepository;

class errornieService extends Service
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, errornieRepository $repo)
    {
        parent::__construct($app, $repo);
    }
}
