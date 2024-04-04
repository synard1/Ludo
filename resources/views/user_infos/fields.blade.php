<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Alamat Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alamat', 'Alamat:') !!}
    {!! Form::text('alamat', null, ['class' => 'form-control', 'required', 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- Telp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telp', 'Telp:') !!}
    {!! Form::text('telp', null, ['class' => 'form-control', 'required', 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- Wa Field -->
<div class="form-group col-sm-6">
    {!! Form::label('wa', 'Wa:') !!}
    {!! Form::text('wa', null, ['class' => 'form-control', 'required', 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>