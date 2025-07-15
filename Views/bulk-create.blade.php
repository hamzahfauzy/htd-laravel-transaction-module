@extends('themes.sneat.app')

@section('title', 'Bulk Create Transaction')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">

        <div class="mb-3"></div>
        
        <form method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Bulk Create Transaction</h4>
                    </div>
                    <div class="card-body">
                        @if(is_array($fields))
                        @include('libraries.components.field', ['fields' => $fields, 'data' => $data, 'page' => $page])
                        @endif

                        @if(is_string($fields))
                        {!! $fields !!}
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
