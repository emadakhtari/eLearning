<style>
    .custom-switch {
        width: 13% !important;
        max-width: 13% !important;
        text-align: center;
    }

    .custom-form-row {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed;
    }
</style>
<div class="col-xs-12">
    <h5>عنوان گروه : {{ $category->title }}</h5>
    <hr>
</div>
<?php $row = 1; ?>
@foreach($modules as $key => $module)
    <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
        <div class="custom-control custom-switch mr-2 mb-1">
            <p class="mb-0">{{trans('modules.'.$key)}}</p>
            <input name="modules[]" type="checkbox" class="custom-control-input" checked id="firstCheck_{{$row}}"
                   value="{{$category->id . '_' . $key}}">
            <label class="custom-control-label" for="firstCheck_{{$row}}">
                <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                <span class="switch-icon-right"><i class="bx bx-x"></i></span>
            </label>
        </div>
        @foreach($module['permissions'] as $perm)
            <div class="custom-control custom-switch mr-2 mb-1">
                <p class="mb-0">{{trans('modules.'.key(json_decode($perm,true)))}}</p>
                <input name="{{$key}}[]" type="checkbox" class="custom-control-input" id="secCheck_{{$row}}"
                       @if(in_array($perm, $userPermission))
                       checked
                       @endif
                       value="{{$perm}}">
                <label class="custom-control-label" for="secCheck_{{$row}}">
                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                </label>
            </div>
            <?php $row++; ?>
        @endforeach
    </div>
@endforeach
