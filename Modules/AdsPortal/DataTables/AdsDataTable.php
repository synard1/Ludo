<?php

namespace Modules\AdsPortal\DataTables;

use Modules\AdsPortal\Entities\Ads;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Nwidart\Modules\Facades\Module;
use App\Models\User;

class AdsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    // public function dataTable($query)
    // {
    //     $dataTable = new EloquentDataTable($query);

    //     return $dataTable
    //             ->rawColumns(['user'])
    //             ->editColumn('user', function (User $user) {
    //                 return view('adsportal::sites.columns._user', compact('user'));
    //             })
    //             ->addColumn('action', function (AdsSite $adssite) {
    //                 return view('adsportal::sites.columns._actions', compact(['adssite' ]));
    //             });
    // }
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['schedule'])
            ->editColumn('schedule', function (Ads $ads) {
                return view('adsportal::ads.columns._actionsSch', compact(['ads' ]));
            })
            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->editColumn('client_id', function ($data) {
                return $data->client->name;
            })
            ->addColumn('action', function (Ads $ads) {
                return view('adsportal::ads.columns._actions', compact(['ads' ]));
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Log $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ads $model)
    {
        // return $model->newQuery();
        return $model->newQuery()->where('type','video')->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    // public function html()
    // {
    //     return $this->builder()
    //         ->columns($this->getColumns())
    //         ->setTableId('adssites-table')
    //         ->minifiedAjax()
    //         ->parameters([
    //             'responsive' => true,
    //             'dom'       => 'Bfrtip',
    //             'stateSave' => true,
    //             'order'     => [[0, 'desc']],
    //         ]);
    // }
    public function html(): HtmlBuilder
    {
        $path = Module::getModulePath('Adsportal');
        return $this->builder()
            ->setTableId('ads-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtp')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents($path.'Resources/views/ads/columns/_draw-scripts.js') . "}");
    }

    /**
     * Get columns.
     *
     * @return array
     */
    // protected function getColumns()
    // {
    //     return [
    //         ['data' => 'sites', 'name' => 'sites', 'title' => 'Sites'],
    //         ['data' => 'address', 'name' => 'address', 'title' => 'Address'],
    //         'status',
    //     ];
    // }
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user_id')->addClass('d-flex align-items-center')->name('user_id'),
            Column::make('client_id'),
            Column::make('name'),
            Column::make('url'),
            Column::make('duration'),
            Column::make('schedule'),
            // Column::make('created_at')->title('Joined Date'),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ads_datatable_' . time();
    }
}
