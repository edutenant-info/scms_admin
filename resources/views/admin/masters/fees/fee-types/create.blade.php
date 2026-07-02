@extends('admin.layouts.master', ['title' => 'New Fee Type'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.fee-types.index') }}">Fee Types</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Fee Type</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.fee-types.store') }}">
        @csrf
        @include('admin.masters.fees.fee-types._form')
    </form>
</div>
@endsection
