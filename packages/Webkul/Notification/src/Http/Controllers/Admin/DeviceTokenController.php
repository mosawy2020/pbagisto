<?php

namespace Webkul\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Webkul\Notification\DataGrids\FcmDataGrid;
use Webkul\Notification\Models\DeviceToken;
use Webkul\Notification\Models\Fcm;
use Webkul\Notification\Repositories\FcmRepository;
use Webkul\Notification\Repositories\NotificationRepository;
use Webkul\Product\Http\Requests\ProductForm;
use Webkul\Customer\Models\CustomerGroup;

class DeviceTokenController extends Controller
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
    public function store(Request $request)
    {
        $data = $request->validate([
                "token" => "required|max:255", "device" => "nullable|max:255"]
        );
        $device_token = DeviceToken::updateOrCreate($data + ["customer_id" => auth()->id()]);

    }

}
