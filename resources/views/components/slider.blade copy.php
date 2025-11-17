<style>
				@media (max-width: 1199px) {
								.col-xl-4 {
												display: flex;
												flex-wrap: wrap;
												justify-content: space-between;
								}

								.img-side-slider {
												width: calc(50%);
												max-height: 132px;
												object-fit: cover;
								}
				}
</style>
<div id="targetSlider" class="row container-fluid container p-0">
				<div class="col-xl-8 p-0">
								<div id="carouselSlider" class="carousel slide" data-bs-ride="carousel">
												<div class="carousel-inner wrap-slide">
																@foreach ($slider->items as $item)
																				<div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
																								<img class="img-fluid" src="{{ asset($item->image) }}" alt="">
																				</div>
																@endforeach
												</div>
												<button class="carousel-control-prev slider-button-left" type="button" data-bs-target="#carouselSlider"
																data-bs-slide="prev">
																<i class="fa fa-chevron-left" aria-hidden="true"></i>
												</button>
												<button class="carousel-control-next slider-button-right" type="button" data-bs-target="#carouselSlider"
																data-bs-slide="next">
																<i class="fa fa-chevron-right" aria-hidden="true"></i>
												</button>
												<div class="carousel-indicators">
																@foreach ($slider->items as $index => $item)
																				<button type="button" data-bs-target="#carouselSlider" data-bs-slide-to="{{ $index }}"
																								class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}">
																				</button>
																@endforeach
												</div>
								</div>
								<div class="carousel-indicators">
												@foreach ($slider->items as $index => $item)
																<button type="button" data-bs-target="#carouselSlider" data-bs-slide-to="{{ $index }}"
																				class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}">
																</button>
												@endforeach
								</div>
				</div>
				<div class="col-xl-4 p-0">
								<img class="img-fluid img-side-slider"
												src="{{ asset($settings->where('setting_key', 'slider_side_image_1')->first()->plain_value) }}"
												alt="">
								<img class="img-fluid img-side-slider"
												src="{{ asset($settings->where('setting_key', 'slider_side_image_2')->first()->plain_value) }}"
												alt="">
				</div>
</div>
