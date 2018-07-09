<?php

namespace App\Modules\errornie\Repositories;

use App\Core\AbstractRepository;
use Illuminate\Contracts\Container\Container;
use App\Modules\errornie\Models\errornie;

class errornieRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, errornie $model)
    {
        parent::__construct($app, $model);
    }
}
