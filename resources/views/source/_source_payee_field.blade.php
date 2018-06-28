<div class="field is-grouped m-b-5 js-addfield-block">
    <?php $index = isset($index) ? $index : '___INDEX___'; ?>
    <input type="hidden" name="payees[{{ $index }}][id]" value="{{ isset($payee) && $payee->id ? $payee->id : '' }}">
    <input name="payees[{{ $index }}][_delete]" value="" type="hidden">
    {!! Form::text('payees[' . $index . '][detail]', isset($payee) && $payee->detail ? $payee->detail : null, ['class' => 'input' ]) !!}
    <a href="#" class="m-t-5 m-l-10 has-text-danger" data-deletefiled="true"><i class="fas fa-times-circle"></i></a>
</div>
