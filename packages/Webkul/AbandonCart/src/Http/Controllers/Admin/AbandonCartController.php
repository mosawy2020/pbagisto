<?php

namespace Webkul\AbandonCart\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Webkul\AbandonCart\Http\Controllers\Controller;
use Webkul\Checkout\Repositories\CartRepository;
use Illuminate\Support\Facades\Mail;
use Webkul\AbandonCart\Mail\AbandonCartNotification;

/**
 * AbandonCart controller for the admin.
 *
 * @author    Rahul Shukla <rahulshukla.symfony527@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class AbandonCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @var array
     */
    protected $_config;

    /**
     * CartRepository object
     *
     * @var \Webkul\Checkout\Repositories\CartRepository
     */
    protected $cartRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Checkout\Repositories\CartRepository  $cartRepository
     * @return void
    */
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;

        $this->middleware('admin');

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the abandon cart.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $cart = $this->cartRepository->findOneWhere([
            'id'           => $id,
            'is_abandoned' => 1,
            'is_active'    => 1,
            'is_guest'     => 0
        ]);

        if (! $cart) {
            abort(404);
        }

        return view($this->_config['view'], compact('cart'));
    }

    /**
     * Send mail for abandon cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendMail($id) {
        try {
            $cart = $this->cartRepository->findOneWhere(['id' => $id]);

            Mail::send(new AbandonCartNotification($cart));

            $cart->is_mail_sent = 1;
            

            $cart->save();

            session()->flash('success', trans('abandoncart::app.abandon-cart.mail.success'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}