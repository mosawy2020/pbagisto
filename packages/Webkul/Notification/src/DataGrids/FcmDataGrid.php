<?php

namespace Webkul\Notification\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Locale;
use Webkul\Customer\Models\CustomerAddress;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Ui\DataGrid\DataGrid;

class FcmDataGrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    public $index = 'id';

    /**
     * Sort order.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Create a new datagrid instance.
     *
     * @return void
     */
    protected $locale = 'all';

    /**
     * Contains the keys for which extra filters to show.
     *
     * @var string[]
     */
    protected $extraFilters = [
        'locales',
    ];

    /**
     * Create a new datagrid instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->locale = core()->getRequestedLocaleCode();
    }


    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
//        $customer = $this->customerRepository->find(request('id'));
        if ($this->locale === 'all') {
            $whereInLocales = Locale::query()->pluck('code')->toArray();
        } else {
            $whereInLocales = [$this->locale];
        }
        $queryBuilder = DB::table('fcms')
            ->leftJoin('fcm_translations', function ($leftJoin) use ($whereInLocales) {
                $leftJoin->on('fcms.id', '=', 'fcm_translations.fcm_id')
                    ->whereIn('fcm_translations.locale', $whereInLocales);
            })
            ->leftJoin('customer_groups as cg', 'fcms.customer_group_id', '=', 'cg.id')
            ->addSelect('fcms.id', 'fcm_translations.title', 'fcm_translations.content', 'cg.name as name',);


////        $this->addFilter('id', 'fcms.id');
//        $this->addFilter('title', 'fcm_translations.title');
//        $this->addFilter('content', 'fcm_translations.content');
//        $this->addFilter('customer_group_name', 'cg.name');

        $this->setQueryBuilder($queryBuilder);


    }



    /**
     * Add columns.
     *
     * @return void
     */


    public function addColumns()
    {

        $this->addColumn([
            'index' => 'id',
            'label' => trans('admin::app.datagrid.id'),
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'title',
            'label' => trans('admin::app.datagrid.title'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'content',
            'label' => trans('admin::app.admin.system.content'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.customers.customers.customer_group'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'wrapper' => function ($value) {
                if ($value->name == null)
                    return 'all';
                else
                  return  $value->name ;
            }
        ]);


    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'title' => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'route' => 'admin.notifications.fcm.edit',
            'icon' => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title' => trans('admin::app.datagrid.delete'),
            'method' => 'POST',
            'route' => 'admin.notifications.fcm.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'address']),
            'icon' => 'icon trash-icon',
        ]);
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
//    public function prepareMassActions()
//    {
//        $this->addMassAction([
//            'type'   => 'delete',
//            'label'  => trans('admin::app.customers.addresses.delete'),
//            'action' => route('admin.customer.addresses.massdelete', request('id')),
//            'method' => 'POST',
//        ]);
//    }
}
