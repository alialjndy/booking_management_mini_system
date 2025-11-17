<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\CreateBookingRequest;
use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $service ;
    public function __construct(BookingService $service)
    {
        $this->service = $service ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny' , Booking::class);
        $bookings = Booking::with('service')->paginate(10);
        return self::paginated($bookings , BookingResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBookingRequest $request)
    {
        $info = $this->service->create($request->validated());
        return $info['status'] == 'success'
            ? self::success([new BookingResource($info['data'])] ,201)
            : self::error('Error Occurred' , $info['status'] , $info['code'] , [$info['error']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view' , $booking);
        $booking = $booking->load('service');
        return self::success([new BookingResource($booking)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $info = $this->service->update($request->validated() , $booking);
        return $info['status'] == 'success'
            ? self::success([new BookingResource($info['data'])])
            : self::error('Error Occurred' , $info['status'] , $info['code'] , [$info['error']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $this->authorize('delete' , $booking);
        $booking->delete();
        return self::success([]);
    }
}
