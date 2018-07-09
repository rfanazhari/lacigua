<?php

namespace App\Modules\api\Repositories;

use App\Core\AbstractRepository;
use Illuminate\Contracts\Container\Container;
use App\Modules\api\Models\api;

class apiRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, api $model)
    {
        parent::__construct($app, $model);
    }
}
