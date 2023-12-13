<?php

namespace Modules\Helpdesk\Http\DataTables;

use App\Models\User;
use Modules\Helpdesk\Entities\Ticket;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Spatie\Permission\Models\Role;

class TicketsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['user'])
            ->editColumn('user', function (User $user) {
                return view('pages.apps.user-management.users.columns._user', compact('user'));
            })
            ->editColumn('last_login_at', function (User $user) {
                return $user->last_login_at ? $user->last_login_at->diffForHumans() : '-';
            })
            ->editColumn('created_at', function (User $user) {
                return $user->created_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (User $user) {
                return view('pages.apps.user-management.users.columns._actions', compact('user'));
            })
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     */
    // public function query(User $model): QueryBuilder
    // {
    //     return $model->newQuery();
    // }
    // public function query(User $model): QueryBuilder
    // {
    //     $query = $model->newQuery();

    //     // Exclude users with the "Super Admin" role if current user doesn't have "Super Admin" role
    //     if (!auth()->user()->hasRole('Super Admin')) {
    //         $query->whereDoesntHave('roles', function ($q) {
    //             $q->where('name', 'Super Admin');
    //         });
    //     }

    //     if (auth()->user()->hasRole('Super Admin')) {
    //         return $query;
    //     }

    //     // Only include users where the parent_id is the current user's id or it is the current user
    //     $query->where(function ($q) {
    //         $q->where('parent_id', auth()->id())
    //         ->orWhere('id', auth()->id());
    //     });

    //     return $query;
    // }

    public function query(User $model): QueryBuilder
    {
        // Get a new query builder instance
        $query = $model->newQuery();

        // Check if the current user is not a "Super Admin"
        if (!auth()->user()->hasRole('Super Admin')) {
            // Exclude users with the "Super Admin" role
            $query->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            });

            // Only include users where the parent_id is the current user's id or it is the current user
            $query->where(function ($q) {
                $q->where('parent_id', auth()->id())
                    ->orWhere('id', auth()->id());
            });
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tickets-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtp')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(3)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//apps/user-management/users/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user')->addClass('d-flex align-items-center')->name('name'),
            Column::make('name'),
            Column::make('last_login_at')->title('Last Login'),
            Column::make('created_at')->title('Joined Date'),
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
        return 'Users_' . date('YmdHis');
    }
}
