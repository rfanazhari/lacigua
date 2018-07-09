<?php

namespace App\Modules\dashboard\Repositories;

use App\Core\AbstractRepository;
use Illuminate\Contracts\Container\Container;
use App\Modules\dashboard\Models\dashboard;

class dashboardRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, dashboard $model)
    {
        parent::__construct($app, $model);
    }
}
