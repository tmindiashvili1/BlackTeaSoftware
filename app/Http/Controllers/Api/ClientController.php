<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientComplaintStoreRequest;
use App\Http\Requests\Client\ClientComplaintUpdateRequest;
use App\Http\Requests\Client\ClientStoreRequest;
use App\Models\Client;
use App\Repository\Contracts\ClientRepositoryInterface;
use App\Repository\Contracts\ComplaintRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * @param ClientStoreRequest $request
     * @param ClientRepositoryInterface $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClientStoreRequest $request, ClientRepositoryInterface $client): \Illuminate\Http\JsonResponse
    {
        $clientEntity = $client->create($request->validated());

        return response()->json([
            'data' => [
                'client' => $clientEntity
            ]
        ]);
    }

    /**
     * @param ClientComplaintStoreRequest $request
     * @param ComplaintRepositoryInterface $complaint
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeComplaint(ClientComplaintStoreRequest $request,ComplaintRepositoryInterface $complaint): \Illuminate\Http\JsonResponse
    {
        $complaintEntity = $complaint->create($request->validated());

        return response()->json([
            'data' => [
                'complaint' => $complaintEntity
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param ClientRepositoryInterface $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function complaints(Request $request,ClientRepositoryInterface $client): \Illuminate\Http\JsonResponse
    {
        $clientEntity = $client->findById($request->get('client_id'),['*'],['complaints']);
        return response()->json([
            'data' => $clientEntity
        ]);
    }

    /**
     * @param ClientComplaintUpdateRequest $request
     * @param $id
     * @param ComplaintRepositoryInterface $complaint
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateComplaint(ClientComplaintUpdateRequest $request,$id,ComplaintRepositoryInterface $complaint): \Illuminate\Http\JsonResponse
    {
        $complaintEntity = $complaint->findById($id);
        $complaintEntity->update([
            'in_work' => $request->get('in_work')
        ]);

        return response()->json([
            'data' => [
                'complaint' => $complaintEntity
            ]
        ]);
    }

}
