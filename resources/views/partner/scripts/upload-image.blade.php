<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"
				integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ=="
				crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css"
				integrity="sha512-C4k/QrN4udgZnXStNFS5osxdhVECWyhMsK1pnlk+LkC7yJGCqoYxW4mH3/ZXLweODyzolwdWSqmmadudSHMRLA=="
				crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
				.tool-edit-cover {
								left: 0%;
								position: absolute;
								width: 150px;
								text-align: center;
								bottom: 0;
								background: #ffffffbd;
								color: #ff5400;
								cursor: pointer;
								top: 80%;
								height: 0px;
				}

				/* Modal styles */
				.modal-edit-image.modal {
								display: none;
								position: fixed;
								align-items: center;
								margin: 0 auto;
								justify-content: center;
								z-index: 3;
								left: 0;
								top: 0;
								width: 100%;
								height: 100%;
								overflow: auto;
								background-color: rgba(0, 0, 0, 0.8);
				}

				.modal-edit-image {
								justify-content: center;
								align-items: center;
				}

				.modal-edit-image .modal-content-edit {
								padding: 20px;
								background-color: #fefefe;
								border: 1px solid #888;
								width: 60%;
				}

				.modal-cover-photo {
								width: 150px;
								position: relative;
				}

				#previewCover {
								border-radius: 50%;
				}

				#previewCover img {
								border-radius: 50%;
								width: 150px !important;
								height: 150px;
								border: 5px solid #fff;
				}

				/* Styles for the Cropper.js container */
				.modal-edit-image .cropper-container {
								margin-top: 32px;
								width: 100%;
								height: fit-content;
								/* Set the desired height */
								max-height: : 300px;
				}

				/* Styles for the crop button */
				.modal-edit-image .crop-button {
								margin-top: 10px;
				}

				/* Styles for the cropped image preview */
</style>

<div id="myModal1" class="modal modal-edit-image">
				<div class="modal-content-edit">
								<div class="cropper-container">
												<img src="" id="modal-image-preview1" alt="Preview">
								</div>
								<div class="py-2 text-end">
												<button style="background-color: #ff7d7d;" type="button" class="close1 btn btn-danger">Đóng</button>
												<button style="background-color: #3d8bf7" id="crop-button1" type="button" class="btn btn-primary">Cắt
																ảnh</button>
								</div>
				</div>
</div>

<!-- Div for cropped image preview -->
<script>
				const imageInput1 = document.getElementById('coverInp');
				const modal1 = document.getElementById('myModal1');
				const modalImagePreview1 = document.getElementById('modal-image-preview1');
				const cropButton1 = document.getElementById('crop-button1');
				const closeButton1 = document.getElementsByClassName('close1')[0];
				const croppedPreview1 = document.getElementById('previewCover');
				let cropper1;

				function openModal1() {
								modal1.style.display = 'flex';
				}

				function closeModal1() {
								modal1.style.display = 'none';
				}
				cropButton1.addEventListener('click', () => {
								const croppedCanvas1 = cropper1.getCroppedCanvas();
								const croppedImage1 = new Image();
								croppedImage1.src = croppedCanvas1.toDataURL();
								croppedPreview1.innerHTML = '';
								croppedPreview1.appendChild(croppedImage1);

								croppedCanvas1.toBlob((blob) => {
												let file = new File([blob], "cover.ext", {
																type: "mime/type",
																lastModified: new Date().getTime()
												});
												let container = new DataTransfer();
												container.items.add(file);
												imageInput1.files = container.files;
												closeModal1();
								});
				});
				closeButton1.addEventListener('click', closeModal1);
				imageInput1.addEventListener('change', (e) => {
								const file1 = e.target.files[0];
								const reader1 = new FileReader();
								reader1.onload = (event) => {
												if (cropper1) {
																cropper1.destroy();
												}
												modalImagePreview1.src = event.target.result;

												cropper1 = new Cropper(modalImagePreview1, {
																aspectRatio: 1,
																viewMode: 1,
												});
												openModal1();
								};
								reader1.readAsDataURL(file1);
				});
</script>
