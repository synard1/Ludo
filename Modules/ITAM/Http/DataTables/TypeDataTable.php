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
use Illuminate\Http\Request;



class TypeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query, Request $request): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_cid', function (AssetType $asset) {
                return $asset->user_cid ?? '-';
            })
            ->editColumn('created_at', function (AssetType $asset) {
                return $asset->created_at->format('d M Y, h:i a');
            })
            ->editColumn('category_id', function (AssetType $asset) {
                return $asset->category->name;
            })
            ->editColumn('type', function (AssetType $asset) {
                // count type for each category
                $count = AssetType::where('category_id', $asset->id)->count();
                return $count ?? 0 ;
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->get('search')['value'] != '') {
                    $searchTerm = $request->get('search')['value'];
            
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%$searchTerm%")
                        ->orWhereHas('category', function ($subquery) use ($searchTerm) {
                            $subquery->where('name', 'like', "%$searchTerm%");
                            // Add more 'orWhere' conditions on 'farms' columns if needed
                        });
                        // Add more 'orWhereHas' conditions for other relationships if needed
                    });
                }
            })
            ->addColumn('action', function (AssetType $transaction) {
                return view('itam::type._actions', compact(['transaction']));
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(AssetType $model): QueryBuilder
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
        // $query->with(['category' => function ($query) {
        //     $query->orderBy('name', 'ASC');
        // }]);
        $query = $model::orderBy('name', 'ASC')
            ->newQuery();

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $modulePath = Module::getModulePath('ITAM');

        return $this->builder()
            ->setTableId('type-table')
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
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/type/_draw-scripts.js') . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('row_number')
                ->title('#')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(50)
                ->orderable(false)
                ->searchable(false)
                ->printable(true),
            Column::make('category_id')->title('Category')->visible(true),
            Column::make('name'),
            Column::make('created_at')->visible(false),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];

        // If the user is Super Admin, add the user_cid column
        if (auth()->user()->level_access === 'Super Admin') {
            $columns[] = Column::make('user_cid')->title('User CID')->visible(true);
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ITAM_Type_' . date('YmdHis');
    }
}
