<?php

namespace App\Modules\api\Services;

use Illuminate\Contracts\Container\Container;
use App\Core\Service;
use App\Modules\api\Repositories\apiRepository;

class apiService extends Service
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Container $app, apiRepository $repo)
    {
        parent::__construct($app, $repo);
    }
}
