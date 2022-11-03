<?php

namespace Webkul\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Webkul\Notification\DataGrids\FcmDataGrid;
use Webkul\Notification\Models\Fcm;
use Webkul\Notification\Repositories\FcmRepository;
use Webkul\Notification\Repositories\NotificationRepository;
use Webkul\Product\Http\Requests\ProductForm;
use Webkul\Customer\Models\CustomerGroup;

class FcmController extends Controller
{
    /**
     * Contains route related configuration.
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected FcmRepository $fcmRepository)
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(FcmDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }


    public function create()
    {
        $customer_groups = CustomerGroup::select("id", "name")->get();
        return view($this->_config['view'], compact('customer_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->customer_group_id) && $request->customer_group_id == "all") $request->request->remove('customer_group_id'); // to remove property from $request

        $rules = ['title' => 'required|max:255',
            'content' => 'required||max:255',
            'image.*' => 'mimes:bmp,jpeg,jpg,png,webp',
        ];
        if (isset($request->customer_group_id) && $request->customer_group_id != "all")
            $rules ['customer_group_id'] =
                ['exists:customer_groups,id'];
        $request->validate($rules);
        $data = request()->except("image");
        $fcm = $this->fcmRepository->create($data);
        $this->fcmRepository->uploadImages($request->all(), $fcm->id);
        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'fcm']));

        return redirect()->route($this->_config['redirect'], ['id' => $fcm->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $notification = Fcm::findorfail($id);
        $customer_groups = CustomerGroup::select("id", "name")->get();
        return view($this->_config['view'], compact('notification', 'customer_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Webkul\Product\Http\Requests\ProductForm $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $locale = $request->locale ?? app()->getLocale();
        $rules = [
            $locale . '.title' => 'required|max:255',
            $locale . '.content' => 'required||max:255',
            'image.*' => 'mimes:bmp,jpeg,jpg,png,webp',
        ];
        if (isset($request->customer_group_id) && $request->customer_group_id != "all")
            $rules ['customer_group_id'] =
                [
                    'exists:customer_groups,id',
                ];
        if (isset($request->customer_group_id) && $request->customer_group_id == "all") $request->merge(['customer_group_id' => null]);


        $request->validate($rules);

        $data = $request->except("image");
        $this->fcmRepository->update($data, $id, request("send"));
        $this->fcmRepository->uploadImages($request->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success'));
        return redirect()->route($this->_config['redirect'], ['id' => $id]);

    }

    public function destroy($id)
    {
        $fcm = $this->fcmRepository->findOrFail($id);

        try {
            $this->fcmRepository->delete($id);

            return response()->json([
                'message' => trans('admin::app.response.delete-success', ['name' => 'fcm']),
            ]);
        } catch (Exception $e) {
            report($e);
        }

        return response()->json([
            'message' => trans('admin::app.response.delete-failed', ['name' => 'fcm']),
        ], 500);
    }


}
