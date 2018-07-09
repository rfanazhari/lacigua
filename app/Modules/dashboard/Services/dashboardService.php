<?php

namespace App\Modules\dashboard\Services;

use Illuminate\Contracts\Container\Container;
use App\Core\Service;
use App\Modules\dashboard\Repositories\dashboardRepository;

class dashboardService extends Service
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, dashboardRepository $repo)
    {
        parent::__construct($app, $repo);
    }
}
