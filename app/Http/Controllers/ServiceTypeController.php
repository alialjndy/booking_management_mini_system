<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\ServiceType;
use App\Services\ServiceType\ManageServices;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    protected $service ;
    public function __construct(ManageServices $service)
    {
        $this->service = $service ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny' ,ServiceType::class);
        $allServices = ServiceType::with('bookings')->paginate(10);
        return self::paginated($allServices , ServiceResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        $info = $this->service->create($request->validated());
        return $info['status'] == 'success'
            ? self::success([new ServiceResource($info['data'])],201)
            : self::error('Error Occurred' , $info['status'] , $info['code'] ,[$info['error']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceType $serviceType)
    {
        $this->authorize('view' ,$serviceType);
        $serviceType = $serviceType->load('bookings');
        return self::success([new ServiceResource($serviceType)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, ServiceType $serviceType)
    {
        $info = $this->service->update($request->validated(), $serviceType);
        return $info['status'] == 'success'
            ? self::success([new ServiceResource($info['data'])])
            : self::error('Error Occurred' , $info['status'] , $info['code'] ,[$info['error']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceType $serviceType)
    {
        $this->authorize('delete' ,$serviceType);
        $serviceType->delete();
        return self::success([]);
    }
}
