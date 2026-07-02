@extends('admin.layouts.master', ['title' => 'New Master Category'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.master-categories.index') }}">Master Categories</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Master Category</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.master-categories.store') }}">
        @csrf
        @include('admin.masters.fees.master-categories._form')
    </form>
</div>
@endsection
