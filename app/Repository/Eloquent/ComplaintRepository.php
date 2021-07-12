<?php


namespace App\Repository\Eloquent;


use App\Models\Client;
use App\Models\Complaint;
use App\Repository\Contracts\ClientRepositoryInterface;
use App\Repository\Contracts\ComplaintRepositoryInterface;

class ComplaintRepository extends BaseRepository implements ComplaintRepositoryInterface
{
    /**
     * @var Client
     */
    protected $model;

    /**
     * ClientRepository constructor.
     * @param Complaint $model
     */
    public function __construct(Complaint $model)
    {
        parent::__construct($model);
    }
}
