<tr class="js-drag-item">
    <?php $index = isset($index) ? $index : '___INDEX___'; ?>
    <td>
        <input type="hidden" name="items[{{ $index }}][id]" value="{{ isset($item) && $item->id ? $item->id : '' }}">
        <input name="items[{{ $index }}][_delete]" value="" type="hidden">
        <div class="field is-grouped m-b-0">
            <p class="control m-t-5">
                <i class="fas fa-bars"></i>
            </p>
            <p class="control">
                {!! Form::text('items[' . $index . '][name]', isset($item) && $item->name ? $item->name : null, ['class' => 'input' ]) !!}
            </p>
        </div>
        @if(isset($index) && isset($errors) && ($errors->has("items.{$index}.name") || $errors->has("items")))
            <p class="help is-danger">{{ $errors->first("items.{$index}.name") }}</p>
        @endif
    </td>
    <td>
        {!! Form::number('items[' . $index . '][price]', isset($item) && $item->price ? $item->price : null, ['class' => 'input js-trigger-change-item' ]) !!}
        @if(isset($index) && isset($errors) && ($errors->has("items.{$index}.price") || $errors->has("items")))
            <p class="help is-danger">{{ $errors->first("items.{$index}.price") }}</p>
        @endif
    </td>
    <td>
        <div class="select">
            {!!
                Form::select('items[' . $index . '][quantity]',
                    array_combine(range(1, 100), range(1, 100)),
                    isset($item) && $item->quantity ? $item->quantity : 1,
                    [ 'class' => 'js-trigger-change-item' ]
                )
            !!}
            @if(isset($index) && isset($errors) && ($errors->has("items.{$index}.quantity") || $errors->has("items")))
                <p class="help is-danger">{{ $errors->first("items.{$index}.quantity") }}</p>
            @endif
        </div>
    </td>
    <td class="has-text-right" style="vertical-align: middle;">
        <span class="js-item-subtotal">{{ (isset($item) && $item->price ? $item->price : 0) }}</span>
        <a href="#" class="m-l-10 has-text-danger" data-deletetable="true"><i class="fas fa-times-circle"></i></a>
    </td>
</tr>
