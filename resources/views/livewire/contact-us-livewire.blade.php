<div>
    <form wire:submit.prevent="save">
        <div class="table-heading">
            <h3>Get In Touch</h3>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6">
                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="Enter your name" wire:model.live="name">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="col-md-6 col-sm-6 col-lg-6">
                <div class="form-group">
                    <input type="text" name="email" id="email" placeholder="Enter your email"
                        wire:model.live="email">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6">
                <div class="form-group">
                    <input type="tel" name="number" id="number" placeholder="Phone Number"
                        wire:model.live="phone_no">
                    @error('phone_no')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6">
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" name="subject" id="subject" placeholder="Subject"
                            wire:model.live="subject">
                        @error('subject')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="form-group">
                    <textarea id="comments" name="comment" placeholder="Enter your comment here..." wire:model.live="message"></textarea>
                    @error('message')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-lg-4">
                <button type="submit" class="submit-btn">Submit Now<span class="cart-icon"></button>
            </div>
        </div>
    </form>
</div>
