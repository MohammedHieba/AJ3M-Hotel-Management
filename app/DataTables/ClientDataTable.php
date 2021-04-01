<?php

namespace App\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Client;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return $this->getClientActionColumn($data);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Client $model)
    {
        return $model->newQuery()->with(["user"]);
       
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            
            Column::make('user.name')->title("Name"),
            Column::make('user.email')->title("Email"),
            Column::make('client.mobile')->title("Mobile"),
            Column::make('client.country')->title("Country"),
            Column::make('client.gender')->title("Gender"),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string$data
     */
    protected function filename()
    {
        return 'Client_' . date('YmdHis');
    }



    protected function getClientActionColumn($data)
    {
        if ($data->receptionist_id == null) {
           
        
           
            return "<div class='d-flex'>"
            ."<a  href='{{ route('client/apply',$data->id)}}' class='btn btn-warning'>Apply</a>"
            ."<div class='form-group'>'
            
            ."<select name ='user_id' class ='form-control' id='post_creator'>"
            ."@foreach ($users as $user)"
                ."<option value='{{$user->id}}'>{{$user->name}}</option>"
              ."@endforeach"
            ."</select>"
            ."</div>"
                

            ."</div>";
        }
    }
}
