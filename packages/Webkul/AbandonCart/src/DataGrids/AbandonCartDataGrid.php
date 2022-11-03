<?php

namespace Webkul\AbandonCart\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;

/**
 * AbandonCartDataGrid Class
 *
 * @author    Rahul Shukla <rahulshukla.symfony527@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class AbandonCartDataGrid extends DataGrid
{
    protected $sortOrder = 'desc'; //asc or desc

    protected $index = 'id';

    protected $itemsPerPage = 20;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('cart')
                ->select('id', 'items_count', 'created_at', 'is_mail_sent')
                ->addSelect(DB::raw('CONCAT(' . DB::getTablePrefix() . 'cart.customer_first_name, " ", ' . DB::getTablePrefix() . 'cart.customer_last_name) as customer_name'))
                ->where('is_abandoned', 1)
                ->where('is_active', 1)
                ->where('is_guest', 0);

        $this->addFilter('customer_name', DB::raw('CONCAT(' . DB::getTablePrefix() . 'cart.customer_first_name, " ", ' .    DB::getTablePrefix() . 'cart.customer_last_name)'));
        $this->addFilter('is_mail_sent', 'cart.is_mail_sent');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('admin::app.datagrid.id'),
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'customer_name',
            'label' => trans('abandoncart::app.datagrid.customer-name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'items_count',
            'label' => trans('abandoncart::app.datagrid.no-of-items'),
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('abandoncart::app.datagrid.date'),
            'type' => 'datetime',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'is_mail_sent',
            'label' => trans('abandoncart::app.datagrid.mail-sent'),
            'type' => 'boolean',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'closure' => true,
            'wrapper'    => function($value) {
                if ($value->is_mail_sent) {
                    return trans('abandoncart::app.datagrid.yes');
                } else {
                    return trans('abandoncart::app.datagrid.no');
                }
            },
        ]);

        $this->addColumn([
            'index' => 'notify',
            'label' => trans('abandoncart::app.datagrid.notify'),
            'type' => 'string',
            'sortable' => false,
            'searchable' => false,
            'filterable' => false,
            'closure' => true,
            'wrapper' => function($row) {
                return '<a class="btn btn-sm btn-primary pay-btn" href="' . route('admin.sales.abandon-cart.mail', $row->id) . '">' . trans('abandoncart::app.datagrid.send-mail')  . '</a>';
            }
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'admin.customers.abandon-cart.view',
            'icon'   => 'icon eye-icon',
        ]);
    }
}