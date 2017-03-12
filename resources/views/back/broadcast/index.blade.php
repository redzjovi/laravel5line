@extends('back._layouts.default')
@section('title', 'Broadcast')

@section('content')
<div class="container">
    {{ Form::open(['url' => Url('back/broadcast')]) }}

    <div class="form-group">
        {{ Form::label('message', 'Message') }}
        {{ Form::textarea('message', '', ['class' => 'form-control']) }}
    </div>

    {{ Form::submit('Send', ['class' => 'btn btn-block btn-primary']) }}
    {{ Form::close() }}
</div>
@endsection