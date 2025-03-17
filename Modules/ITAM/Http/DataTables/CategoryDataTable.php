<?php

namespace Modules\ITAM\Http\DataTables;

use Modules\ITAM\Entities\AssetCategory;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\ITAM\Entities\AssetType;
use Yajra\DataTables\Html\ColumnDefinition;


class CategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (AssetCategory $asset) {
                return $asset->created_at->format('d M Y, h:i a');
            })
            // ->editColumn('category_id', function (Asset $asset) {
            //     return $asset->category->name;
            // })
            ->editColumn('type', function (AssetCategory $asset) {
                // count type for each category
                $count = AssetType::where('category_id', $asset->id)->count();
                return $count ?? 0 ;
            })
            // ->editColumn('manufacturer_id', function (Asset $asset) {
            //     return $asset->manufacturer->name;
            // })

            // ->editColumn('user_id', function (Asset $asset, Company $company, User $user) {
            //     $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';
            //     if($isSuperAdmin){
            //         $data = $company->where('cid',$asset->user_cid)->first();
            //         return $data->name;
            //     }else{
            //         $data = $user->where('id',$asset->user_id)->first();
            //         return $data->name;

            //     }
                
            // })
            ->addColumn('action', function (AssetCategory $transaction) {
                // $isOwner = auth()->check() && auth()->user()->level_access === 'Owner';
                // $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                // return $isSupervisor ? view('itam::asset._actions', compact(['asset','isSupervisor'])) : '';
                return view('itam::category._actions', compact(['transaction']));
            })
            // ->filterColumn('status', function($query, $keyword) {
            //     $sql = "itsm_assets.status  like ?";
            //     $query->where($sql, ["%{$keyword}%"]);
            // })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(AssetCategory $model): QueryBuilder
    {
        $user = auth()->user();

        $query = $model->newQuery();

        // Adjust the query based on user's level_access
        if ($user->level_access != 'Super Admin') {
            $query->where('user_cid', $user->cid);
        } elseif ($user->level_access == 'Owner') {
            $query->where('user_cid', $user->cid);
        }

        // Include sorting by report_time from the reported relation
        // $query->with(['reported' => function ($query) {
        //     $query->orderBy('number', 'DESC');
        // }]);
        $query = $model::orderBy('id', 'DESC')
            ->newQuery();

        return $query;
    }

    // public function query(Asset $model): QueryBuilder
    // {
    //     // Get a new query builder instance
    //     $user = auth()->user();

    //     if(!auth()->user()->level_access == 'Super Admin'){
    //         $query = $model->where('user_cid', $user->cid)
    //                         ->newQuery();
    //     }elseif(auth()->user()->level_access == 'Owner'){
    //         $query = $model->where('user_cid', $user->cid)
    //                         ->newQuery();
    //     }else{
    //         // Get a new query builder instance
    //         $query = $model->newQuery();
    //     }
    
    //     return $query;
    // }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $modulePath = Module::getModulePath('ITAM');

        return $this->builder()
            ->setTableId('category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtlip')
            ->addTableClass('table align-middle table-row-dashed dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->parameters([
                'scrollX'      =>  true,
                'lengthMenu' => [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                'buttons'      => ['export', 'print', 'reload','colvis'],
            ])
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/category/_draw-scripts.js') . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('row_number')
                    ->title('#')
                    ->render('meta.row + meta.settings._iDisplayStart + 1;')
                    ->width(50)
                    // ->controls(false)
                    ->orderable(false)
                    ->searchable(false)
                    ->printable(true),
            Column::make('name'),
            // Column::make('category_id')->title('Category')->visible(false),
            Column::computed('type')->title('Type Count')->visible(true),
            // Column::make('manufacturer_id')->visible(false),
            // Column::computed('model'),
            Column::make('created_at')->visible(false),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ITAM_Category_' . date('YmdHis');
    }
}
