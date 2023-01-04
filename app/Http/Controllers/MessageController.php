<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\GetListMessageRequest;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    public function __construct(protected MessageService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(GetListMessageRequest $request)
    {
        $data = $this->service->getList($request->validated());
        return MessageResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMessageRequest $request)
    {
        $this->service->store($request->validated());
        return Redirect::back()->with(['success' => true, 'errorMessage' => '']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
