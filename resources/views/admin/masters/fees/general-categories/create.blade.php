@extends('admin.layouts.master', ['title' => 'New General Category'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.general-categories.index') }}">General Categories</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New General Category</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.general-categories.store') }}">
        @csrf
        @include('admin.masters.fees.general-categories._form')
    </form>
</div>
@endsection
