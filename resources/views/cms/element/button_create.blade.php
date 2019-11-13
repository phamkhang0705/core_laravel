<div class="btn-create-new">
    <a href="{{$url }}">
        <button type="button"
                class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"
                @if(isset($tooltip) && $tooltip!='')
                data-toggle="tooltip"
                data-original-title="{!! $tooltip !!}"
                data-placement="left"
                @endif
        >
            <i class="material-icons">add</i>
        </button>
    </a>
</div>