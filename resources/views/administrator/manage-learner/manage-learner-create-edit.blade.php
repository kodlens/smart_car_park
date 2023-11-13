@extends('layouts.admin')

@section('content')


    <manage-learner-create-edit
            prop-data='@json($data)'
            :prop-data-id="{{ $id }}"></manage-learner-create-edit>
@endsection

