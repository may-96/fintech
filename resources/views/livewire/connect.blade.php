

@push('styles')

@endpush

<section>


    <section class="wrapper">
        <div class="container">
            <div class="d-flex">
                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <h2 class="display-4 mb-3 text-center">Step 1</h2>
                    <p class="lead text-center mb-10 " style="display: block;">Select your country and banks you want to connect.</p>
                    <form class="contact-form needs-validation" method="post" action="" novalidate>
                        <div class="messages"></div>
                        <div class="d-flex justify-content-evenly flex-column">
                            <div class="col-md-12">
                                <div >
                                    <div class="form-select-wrapper" wire:ignore>
                                        <select wire:model="selected " class="custom_select form-select">
                                            @foreach ($countries as $country)
                                                <option value="{{$country->alpha_2_code}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select a country. </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-select-wrapper mb-4">
                                    <select class="form-select" id="bank" name="bank" required>

                                        <option selected disabled value="">Select your bank</option>
                                        <option value="meezan">Meezan</option>
                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select a country. </div>
                                </div>
                            </div>
                            <div class="divider-icon my-8"><i class="uil">Agreement Details</i></div>
                            <div class="d-flex flex-column justify-content-between  flex-sm-row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating mb-4">
                                        <input id="accessdays" type="number" class="form-control" placeholder="select number of days" value="90" required>
                                        <label for="accessdays">Access Days *</label>
                                        <div class="valid-feedback"> Looks good! </div>
                                        <div class="invalid-feedback"> Please provide a valid no of days. </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input id="maxdays" type="number" class="form-control" placeholder="select no of days" value="90" required>
                                        <label for="maxdays">Max access days *</label>
                                        <div class="valid-feedback"> Looks good! </div>
                                        <div class="invalid-feedback"> Please provide a valid no of days. </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                </div>
                            </div>
                            <div class="col-md-12 form-check">
                                <input type="checkbox" class="form-check-input" id="balance" name="balance" value="Balance">
                                <label class="form-check-label" for="balance">Bank Balance</label>
                            </div>
                            <div class="col-md-12 form-check">
                                <input type="checkbox" class="form-check-input" id="details" name="details" value="details">
                                <label class="form-check-label" for="details"> Account Details</label>
                            </div>
                            <div class="col-md-12 form-check">
                                <input type="checkbox" class="form-check-input" id="transaction" name="transaction" value="transaction">
                                <label class="form-check-label" for="transaction"> Transaction Data</label>
                            </div>


                            <!-- /column -->
                            <div class="col-12 text-center mb-20">
                                <input type="submit" id="n1" onclick="next()" class="btn btn-primary rounded-pill btn-send mb-3" value="Next">
                                <p class="text-muted"><strong>*</strong> These fields are required.</p>
                            </div>
                            <!-- /column -->
                        </div>
                        <!-- /.row -->
                    </form>
                    <!-- /form -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
    </section>
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
