<section>
    <div>
        <div wire:ignore>
            <select wire:model="selected" class="custom_select">
                @foreach ($countries as $country)
                    <option value="{{$country->alpha_2_code}}">{{$country->name}}</option>
                @endforeach
            </select>
        </div>
        <span>{{$selected}}</span>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.custom_select').select2();
        $('.custom_select').on('change', () => {
            let data = $('.custom_select').select2("val");
            @this.set('selected', data);
            @this.format();
        })
    });
</script>
@endpush