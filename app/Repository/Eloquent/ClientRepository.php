<?php


namespace App\Repository\Eloquent;


use App\Models\Client;
use App\Repository\Contracts\ClientRepositoryInterface;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{
    /**
     * @var Client
     */
    protected $model;

    /**
     * ClientRepository constructor.
     * @param Client $model
     */
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }
}
