<?php

namespace App\Modules\frontend1\Repositories;

use App\Core\AbstractRepository;
use Illuminate\Contracts\Container\Container;
use App\Modules\frontend1\Models\frontend1;

class frontend1Repository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, frontend1 $model)
    {
        parent::__construct($app, $model);
    }
}
