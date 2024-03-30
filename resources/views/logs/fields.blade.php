<!-- Http Method Field -->
<div class="form-group col-sm-6">
    {!! Form::label('http_method', 'Http Method:') !!}
    {!! Form::text('http_method', null, ['class' => 'form-control', 'required', 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control', 'required', 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- Http Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('http_status', 'Http Status:') !!}
    {!! Form::number('http_status', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Ip Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip_address', 'Ip Address:') !!}
    {!! Form::text('ip_address', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- User Agent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_agent', 'User Agent:') !!}
    {!! Form::text('user_agent', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>