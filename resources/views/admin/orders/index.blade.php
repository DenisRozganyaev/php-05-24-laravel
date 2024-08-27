@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>@sortablelink('id', 'ID')</th>
                        <th>@sortablelink('status.name', 'Status')</th>
                        <th>@sortablelink('total', 'Total')</th>
                        <th>@sortablelink('created_at', 'Created At')</th>
                        <th>@sortablelink('updated_at', 'Updated At')</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->status->name}}</td>
                            <td>{{$order->total}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->updated_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
